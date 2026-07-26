<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EResource extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'url', 'category', 'school', 'department', 'order', 'file_path', 'file_type'];
}
