<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribedResource extends Model
{
    protected $fillable = ['title', 'url', 'description', 'order'];
}
