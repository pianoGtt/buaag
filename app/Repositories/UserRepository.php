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

}
