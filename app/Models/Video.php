<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Video extends Model
{   
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_language',
        'video',
        'video_url',
        'status',
        'user_id'
    ];
}
