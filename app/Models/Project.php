<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'nerd_uploaded' => 'boolean',
        'submission_date' => 'date',
        'approval_date' => 'date',
    ];





    public function authors()
    {
        return $this->hasMany(ProjectAuthor::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
