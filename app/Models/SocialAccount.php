<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;
    protected $hidden = ['user_id'];
    protected $fillable = [
        'user_id',
        'access_token' ,
        'refresh_token' ,
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
