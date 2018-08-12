<?php
/**
 * User follow
 *
 * @package Controller
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 17:25
 */
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\FollowRepository;

class FollowsController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var FollowRepository
     */
    protected $follow;

    public function __construct(FollowRepository $follow, UserRepository $user)
    {
        $this->user = $user;
        $this->follow = $follow;
    }

    /**
     * 通过用户id获取此用户关注的用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $follows = $this->follow->list([
            ['user_id', $parameters['user_id']],
            ['status', 1]
        ])->toArray();
        $list = [];
        if (count($follows['data']) > 0) {
            $userInfo = $this->user->getById($parameters['user_id']);
            if (is_null($userInfo)) {
                return $this->fail('获取用户信息失败');
            }
            $followUserIds = array_column($follows['data'], 'follow_user_id');
            $followUserList = $this->user->getUserListById($followUserIds);

            foreach ($follows['data'] as $item) {
                $data['id'] = $item['id'];
                $data['user_id'] = $item['user_id'];
                $data['user_name'] = $userInfo->name;
                $data['follow_user_id'] = $item['follow_user_id'];
                $data['follow_user_name'] = $followUserList[$item['follow_user_id']]['name'];
                $list[] = $data;
                unset($data);
            }
        }

        $data = [
            'data' => $list,
            'currentPage' => $follows['current_page'],
            'total' => $follows['total'],
            'lastPage' => $follows['last_page'],
            'perPage' => $follows['per_page'],
        ];
        return $this->success($data);
    }

    /**
     * 关注
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'follow_user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $followInfo = $this->follow->getByWhere([
            ['user_id', $parameters['user_id']],
            ['follow_user_id', $parameters['follow_user_id']],
            ['status', 1]
        ]);
        if (!is_null($followInfo)) {
            return $this->fail('不可以重复关注');
        }
        $result = $this->follow->store([
            'user_id' => $parameters['user_id'],
            'follow_user_id' => $parameters['follow_user_id'],
        ]);
        if ($result) {
            return $this->success();
        }
        return $this->fail();
    }

    /**
     * 取消关注
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'follow_user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $followInfo = $this->follow->getByWhere([
            ['user_id', $parameters['user_id']],
            ['follow_user_id', $parameters['follow_user_id']],
            ['status', 1]
        ]);
        if (is_null($followInfo)) {
            return $this->fail('您还未关注此用户');
        }
        $result = $this->follow->update($followInfo->id, ['status' => 2]);
        if ($result) {
            return $this->success();
        }
        return $this->fail();
    }

}
