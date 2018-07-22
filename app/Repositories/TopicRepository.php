<?php
/**
 * Topic Repository
 *
 * @package Repository
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 17:41
 */

namespace App\Repositories;


use App\Models\Topic;

class TopicRepository
{
    use BaseRepository;

    /**
     * @var Topic
     */
    protected $model;

    /**
     * TopicRepository constructor.
     *
     * @param Topic $topic
     */
    public function __construct(Topic $topic)
    {
        $this->model = $topic;
    }

}