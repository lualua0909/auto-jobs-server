<?php

namespace App\GraphQL\Queries;

use App\Models\Contract;
use App\Models\Job;
use App\Models\JobSaved;
use App\Models\User;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class JobsQuery extends Query
{
    protected $attributes = [
        'name' => 'Jobs',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Job');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'default' => 4,
            ],
            'page' => [
                'type' => Type::int(),
                'default' => 1,
            ],
            'except_by_id' => [
                'type' => Type::listOf(Type::int()),
                'default' => null,
            ],
            'condition' => [
                'type' => Type::string(),
            ],
            'near_by' => [
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $query = new Job;

        // Loại bỏ những job_id không muốn hiển thị
        if (isset($args['except_by_id']) && is_array($args['except_by_id'])) {
            $query = $query->whereNotIn('id', $args['except_by_id']);
        }

        // Nếu là người tuyển dụng thì chỉ hiển thị công việc của mình
        if (auth()->user()->role === 'employer') {
            $query = $query->where('created_by', auth()->id());
        }

        // Lất công việc theo trạng thái đã hoàn thành hay chưa
        // if (isset($args['condition'])) {
        //     $now = date('Y-m-d H:i:s');

        //     if ($args['condition'] === 'doing') {
        //         $query = $query->where([
        //             ['start_time', '<=', $now],
        //             ['end_time', '>=', $now],
        //         ]);
        //     } else if ($args['condition'] === 'done') {
        //         $query = $query->where('end_time', '<', $now);
        //     }
        // }

        // Kiểm tra điều kiện near_by để lấy ra các công việc gần nhất
        if (isset($args['near_by'])) {
            $user = User::find(auth()->id());
            $query = $query->where('province_id', $user->province_id);
        }

        $query = $query->paginate($args['limit'], ['*'], 'page', $args['page']);

        /** @var SelectFields $fields */
        $select = $getSelectFields()->getSelect();

        if (in_array('status', $select) && auth()->user()->role === 'user') {
            foreach ($query as $row) {
                // Lấy ra trạng thái công việc đối với người dùng hiện tại
                $row->status = Contract::where([
                    'job_id' => $row->id,
                    'user_id' => auth()->id(),
                ])->first()->status ?? 'not_applied';

                // Kiểm tra xem công việc đã được lưu hay chưa
                $row->isSaved = JobSaved::where([
                    'job_id' => $row->id,
                    'user_id' => auth()->id(),
                ])->first() ? true : false;
            }
        }

        if (in_array('isSaved', $select) && auth()->user()->role === 'user') {
            foreach ($query as $row) {
                // Kiểm tra xem công việc đã được lưu hay chưa
                $row->isSaved = JobSaved::where([
                    'job_id' => $row->id,
                    'user_id' => auth()->id(),
                ])->first() ? true : false;
            }
        }

        return $query;
    }
}
