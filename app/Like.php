<?php

namespace heychum;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';

    protected $fillable = [
        'user_id', 'likeable_id',
    ]; 

    public function likeable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('heychum\Like', 'user_id');
    }
}
