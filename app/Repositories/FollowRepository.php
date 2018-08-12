<?php
/**
 * Follow Repository
 *
 * @package Repository
 * @author: 姚树标 <yaoshubiao@gmail.com>
 * @DateTime: 2018/8/12 14:52
 */

namespace App\Repositories;


use App\Models\Follow;

class FollowRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Follow $follow)
    {
        $this->model = $follow;
    }
}