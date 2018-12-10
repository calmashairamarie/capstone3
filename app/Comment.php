<?php

namespace heychum;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
        'comment_id',
    ];
   public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

     public function posts()
    {
        return $this->belongsTo(Comment::class);
    }
}
