<?php

namespace App\Models;

use App\Models\User;
use App\Models\Postings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    protected $connection = 'mysql_post';
    protected $table = 'posts';

    protected $fillable = ['title', 'content'];

   public function postings()
    {
        return $this->hasOne(Postings::class,'post_id');
    }

    use HasFactory;
}
