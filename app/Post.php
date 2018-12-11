<?php

namespace heychum;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{


	protected $fillable = [
        'user_id', 'parent_id', 'body', 'image', 'title', 'shared_id', 'shared_title', 'shared_body', 'shared_image', 'shared_name',
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function likes()
    {
        return $this->morphMany('heychum\Like', 'likeable');
    }
}
