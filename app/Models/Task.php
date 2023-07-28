<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'assigned_user',
        'assigned_project',
        'started_at',
        'closed_at',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'assigned_user');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'assigned_project');
    }
}
