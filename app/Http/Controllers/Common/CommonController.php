<?php
/**
 * common controller class
 *
 * @package Controller
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 11:35
 */

namespace App\Http\Controllers\Common;


use Storage;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    /**
     * upload file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $parameters = $request->all();
        $validator = Validator::make($parameters, [
            'picture' => ['required', 'file', 'image', 'max:10240'],
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        $disk = Storage::disk('qiniu');

        $fileName = 'buaa' . str_random(5) . date('YmdHis') . '.jpg';

        $res = $disk->put($fileName, file_get_contents($parameters['picture']));
        if ($res) {
            $url = $this->getUrl($fileName);
            return $this->success([
                'img_name' => substr($url, 33),
            ]);
        }
        return $this->fail();
    }

    /**
     * Get image url bug file name
     *
     * @param $fileName
     * @return mixed
     */
    public function getUrl($fileName)
    {
        $disk = Storage::disk('qiniu');

        return $disk->getUrl($fileName);
    }
}