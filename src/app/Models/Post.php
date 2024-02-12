<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    /**
     * usersテーブルへのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * communityテーブルへのリレーション
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
