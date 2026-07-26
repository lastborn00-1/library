<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'email',
        'qualifications',
        'bio',
        'phone',
        'image_path',
        'order',
    ];
}
