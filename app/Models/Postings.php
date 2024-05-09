<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Postings extends Model
{
    use HasFactory;
    protected $connection = 'mysql_post';
    protected $table = 'posting';
    protected $fillable = ['user_id','post_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }

}
