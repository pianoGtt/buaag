<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The fillable attributes on the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password'
    ];
}