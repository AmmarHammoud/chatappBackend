<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reset_code_password extends Model
{
    use HasFactory;
    protected $fillable=[
        'code',
        'email',
        'created_at'
        ];
}
