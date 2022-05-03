<?php

declare (strict_types = 1);

namespace App\GraphQL\Mutations\Contract;

use App\Models\Contract;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateContractMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateContract',
        'description' => 'A mutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('Contract');
    }

    public function args(): array
    {
        return [
            'job_id' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required'],
            ],
            'user_id' => [
                'type' => Type::int(),
            ],
            'employer_id' => [
                'type' => Type::int(),
            ],
            'action' => [
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (auth()->user()->role === 'user') {
            $contract = Contract::where([
                'job_id' => $args['job_id'],
                'user_id' => auth()->id(),
                'employer_id' => $args['employer_id'],
            ])->first();

            // user được accept những contract [approved]
            if ($args['action'] === 'approved' && $contract->status === 'approved') {
                $contract->status = 'accepted';

                $template_id = 5; // đơn ứng tuyển được chấp nhận
            } else if ($args['action'] === 'rejected') {
                $contract->status = 'cancelled';

                $template_id = 7; // đơn ứng tuyển bị từ chối
            }

            $user_id = $args['employer_id']; // id của nhà tuyển dụng nhận thông báo
        } else if (auth()->user()->role === 'employer') {
            $contract = Contract::where([
                'job_id' => $args['job_id'],
                'employer_id' => auth()->id(),
                'user_id' => $args['user_id'],
            ])->first();

            // employer được accept những contract [waiting, accepted, doing]
            if ($args['action'] === 'approved') {
                if ($contract->status === 'waiting') {
                    $contract->status = 'approved';

                    $template_id = 4; // công việc được xác nhận
                } else if ($contract->status === 'accepted') {
                    $contract->status = 'doing';

                    $template_id = 4; // đơn ứng tuyển đang thực hiện
                } else if ($contract->status === 'doing') {
                    $contract->status = 'done';

                    $template_id = 4; // đơn ứng tuyển hoàn thành
                }
            } else if ($args['action'] === 'rejected') {
                $contract->status = 'rejected';

                $template_id = 7; // đơn ứng tuyển bị từ chối
            }

            $user_id = $args['user_id']; // id của ứng viên nhận thông báo
        }

        $contract->save();

        $user = User::find($user_id);
        if ($user && $template_id) {
            //tạo thông báo cho người nhận
            $notification = new Notification;
            $notification->fill([
                'template_id' => $template_id,
                'user_id' => $user->id,
            ]);
            $notification->save();

            if ($user->fcm_token) {
                $job = Job::find($args['job_id']);

                $template = NotificationTemplate::find($template_id);

                $body = str_replace("{{param_1}}", $job->title, $template->content);
                $body = str_replace("{{param_2}}", $user->name, $body);

                send_fcm($user->fcm_token, $template->title, $body, null);
            }
        }

        return $contract ?? null;
    }
}
