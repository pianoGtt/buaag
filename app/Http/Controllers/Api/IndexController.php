<?php
/**
 * 类说明
 *
 * @package Controller
 * @author: 姚树标 <yaoshubiao@xin.com>
 * @DateTime: 2018/7/10 19:34
 */

namespace App\Http\Controllers\Api;


use Storage;
use Illuminate\Http\Request;

class IndexController
{
    public function index(Request $request)
    {
        $params = $request->input();
        dd($params);
        /*$file = $request->file('photo');

        $disk = \Storage::disk('qiniu');
        $url = $disk->getUrl('avatars/filename.jpg');
        dd($url);
        //http://pbmzeu9us.bkt.clouddn.com/avatars/filename.jpg
        $fileName = date('YmdHis') . 'buaa' . str_random(10) . '.jpg';
        dd($fileName);
        $res = $disk->put($fileName, file_get_contents($file));
        dd($res);*/
    }

}
