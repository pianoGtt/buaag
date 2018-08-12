<?php
/**
 * User Repository
 *
 * @package Repository
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 09:47
 */

namespace App\Repositories;


use App\Models\User;

class UserRepository
{
    use BaseRepository;

    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * 获取用户信息
     *
     * @param array $userIds
     * @return User
     */
    public function getUserListById(array $userIds)
    {
        return $this->model->whereIn('id', $userIds)->get()->keyBy('id')->toArray();
    }

}
