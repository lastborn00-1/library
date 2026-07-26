<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'status',
        'profile_photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
