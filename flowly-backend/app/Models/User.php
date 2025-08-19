<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $fillable = ['email', 'username', 'password'];
}
