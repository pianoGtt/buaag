<?php
/**
 * 类说明
 *
 * @package Services
 * @author: 姚树标 <yaoshubiao@xin.com>
 * @DateTime: 2018/8/12 14:51
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'follows';

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'follow_user_id',
        'status',
    ];
}
