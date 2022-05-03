<?php

namespace App\GraphQL\Mutations\Contract;

use App\Models\Contract;
use App\Models\Job;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateContractMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createContract',
        'description' => 'Contract mutation',
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
        ];
    }

    public function resolve($root, $args)
    {
        $job = Job::find($args['job_id']);
        $role = auth()->user()->role;
        $template_id = null;
        
        if ($role === 'user') {
            $contract = Contract::firstOrCreate([
                'job_id' => $args['job_id'],
                'user_id' => auth()->id(),
                'employer_id' => $job->created_by,
            ], ['status' => 'waiting']);

            $user_id = $job->created_by; // id của nhà tuyển dụng nhận thông báo
            $template_id = 6; // đơn ứng tuyển chờ đuyệt
        } else if ($role === 'employer') {
            $contract = Contract::firstOrCreate([
                'job_id' => $args['job_id'],
                'user_id' => $args['user_id'],
                'employer_id' => auth()->id(),
            ], ['status' => 'approved']);

            $user_id = $args['user_id']; // id của ứng viên nhận thông báo
            $template_id = 4; // công việc được xác nhận
        }

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
                $template = NotificationTemplate::find($template_id);
                $body = str_replace("{{param_1}}", $job->title, $template->content);
                $body = str_replace("{{param_2}}", $user->name, $body);

                send_fcm($user->fcm_token, $template->title, $body, null);
            }
        }

        return $contract ?? null;
    }
}
