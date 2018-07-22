<?php
/**
 * Sign in
 *
 * @package Controller
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018-07-21 22:50
 */

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $model;

    /**
     * UserController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->model = $user;
    }

    /**
     * User index
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => [
                'required',
                'integer',
            ],
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $userInfo = $this->model->getById($parameters['user_id']);
        if (is_null($userInfo)) {
            return $this->fail('用户不存在！');
        }

        $data = [
            'id' => $userInfo->id,
            'name' => $userInfo->name,
            'avatar' => $userInfo->avatar,
            'phone' => $userInfo->phone,
            'topic_count' => $userInfo->topic_count,
            'idol_count' => $userInfo->idol_count,
            'fans_count' => $userInfo->fans_count,
        ];
        return $this->success($data);
    }

    /**
     * Sign in
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'type' => [
                'required',
                Rule::in([1])
            ],
            'phone' => [
                'required',
                'regex:/^[1][3,4,5,6,7,8,9][0-9]{9}$/'
            ],
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $result = $this->model->firstOrCreate([
            'phone' => $parameters['phone']
        ], [
            'name' => '',
            'email' => date('his') . str_random(4) . '@gmail.com',
            'password' => sha1(date('his') . str_random(16)),
        ]);

        if ($result) {
            return $this->success();
        }
        return $this->fail();
    }

}
