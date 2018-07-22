<?php
/**
 * Topic class
 *
 * @package Controller
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 17:25
 */

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;

class TopicController extends Controller
{
    /**
     * The topic repository instance.
     *
     * @var TopicRepository
     */
    protected $topic;

    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * TopicController constructor.
     *
     * @param TopicRepository $topic
     */
    public function __construct(TopicRepository $topic, UserRepository $user)
    {
        $this->topic = $topic;
        $this->user = $user;
    }


    /**
     * Get topic list by user id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perpage = $request->get('perpage') ?: 10;
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        $where = [
            ['user_id', $parameters['user_id']]
        ];
        $topics = $this->topic->list($where, $perpage);

        $data = [
            'data' => $topics->items(),
            'currentPage' => $topics->currentPage(),
            'total' => $topics->total(),
            'lastPage' => $topics->lastPage(),
            'perPage' => $topics->perPage(),
        ];
        return $this->success($data);
    }

    /**
     * Get topic detail by topic id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'topic_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $topic = $this->topic->getById($parameters['topic_id']);
        if (is_null($topic)) {
            return $this->fail('话题不存在');
        }
        return $this->success([
            'id' => $topic->id,
            'comment_count' => $topic->comment_count,
            'look_count' => $topic->look_count,
            'user_id' => $topic->user_id,
            'user_name' => $topic->user_name,
            'images' => $topic->images,
            'content' => $topic->content,
            'created_at' => $topic->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Topic content store
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'user_id' => 'required|integer',
            'content' => 'required|max:1000',
            'images' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }

        $userInfo = $this->user->getById($parameters['user_id']);
        if (is_null($userInfo)) {
            return $this->fail('用户不存在');
        }
        $result = $this->topic->store([
            'user_id' => $parameters['user_id'],
            'user_name' => $userInfo->name,
            'content' => $parameters['content'],
            'images' => $parameters['images'],
        ]);
        if ($result) {
            return $this->success();
        }
        return $this->fail();
    }

}
