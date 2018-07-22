<?php
/**
 * Topic comment
 *
 * @package Controller
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 17:25
 */

namespace App\Http\Controllers\Api;


use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Repositories\UserRepository;
use App\Repositories\TopicRepository;
use App\Repositories\CommentRepository;


class CommentController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * The comment repository instance.
     *
     * @var CommentRepository
     */
    protected $comment;

    /**
     * The topic repository instance.
     *
     * @var TopicRepository
     */
    protected $topic;

    /**
     * CommentController constructor.
     *
     * @param UserRepository $user
     * @param TopicRepository $topic
     * @param CommentRepository $comment
     */
    public function __construct(CommentRepository $comment, UserRepository $user, TopicRepository $topic)
    {
        $this->user = $user;
        $this->topic = $topic;
        $this->comment = $comment;
    }


    /**
     * Get topic comment by topic id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perpage = $request->get('perpage') ?: 10;
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'topic_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        $comments = $this->comment->list([
            ['topic_id', $parameters['topic_id']]
        ], $perpage);

        $data = [
            'data' => $comments->items(),
            'currentPage' => $comments->currentPage(),
            'total' => $comments->total(),
            'lastPage' => $comments->lastPage(),
            'perPage' => $comments->perPage(),
        ];
        return $this->success($data);
    }

    /**
     * add a comment to topic
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'topic_id' => 'required|integer',
            'content' => 'required|max:199',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        $cacheKey = $parameters['user_id'] . $parameters['topic_id'];
        $value = Cache::get($cacheKey);
        if ($value) {
            return $this->fail('5分钟内不可重复评论！');
        }
        Cache::add($cacheKey, $parameters['user_id'], 5);

        $userInfo = $this->user->getById($parameters['user_id']);
        if (is_null($userInfo)) {
            return $this->fail('用户不存在');
        }

        $result = $this->comment->store([
            'user_id' => $parameters['user_id'],
            'topic_id' => $parameters['topic_id'],
            'user_name' => $userInfo->name,
            'content' => $parameters['content'],
        ]);
        if ($result) {
            $this->topic->increment([
                ['id', $parameters['topic_id']]
            ], 'comment_count');
            return $this->success();
        }
        return $this->fail();
    }
}