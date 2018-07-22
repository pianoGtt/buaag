<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id',
        'user_name',
        'user_id',
        'content',
    ];
}
