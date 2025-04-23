<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'sequence', 'description', 'subject_id'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (empty($topic->sequence)) {
                $maxSequence = self::where('subject_id', $topic->subject_id)->max('sequence');
                $topic->sequence = $maxSequence + 1;
            }
        });
    }
}
