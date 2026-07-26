<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastQuestion extends Model
{
    protected $fillable = ['title', 'department', 'course_code', 'year', 'file_path', 'file_type', 'allow_download'];

    protected $casts = [
        'allow_download' => 'boolean',
    ];
}
