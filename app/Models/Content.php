<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = "content";
    protected $fillable = [
        'topic_id',
        'title',
        'slug',
        'body',
        'sequence',
        'is_active',
    ];
}
