<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'reaction_type',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
{
    return $this->belongsTo(message::class);
}

}
