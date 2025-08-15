<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'tasks';
    protected $fillable = ['_id', 'user_id', 'title', 'description', 'status', 'created_at', 'updated_at'];
}
