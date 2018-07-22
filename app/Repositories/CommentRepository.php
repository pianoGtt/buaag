<?php
/**
 * Comment Repository
 *
 * @package Repository
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 19:28
 */

namespace App\Repositories;


use App\Models\Comment;

class CommentRepository
{
    use BaseRepository;

    /**
     * @var Comment
     */
    protected $model;

    /**
     * TopicRepository constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}