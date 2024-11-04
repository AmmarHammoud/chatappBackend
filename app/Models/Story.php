<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'media_path',
        'expires_at',];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // فحص الصلاحية (هل الستوري منتهية الصلاحية)
    public function isExpired()
    {
        return $this->expires_at < carbon::now();
    }
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }
}
