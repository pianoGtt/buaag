<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topics';

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'content',
        'images',
        'comment_count',
        'look_count'
    ];
}
