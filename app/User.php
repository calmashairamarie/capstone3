<?php

namespace heychum;


use heychum\Post;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username', 'profile_pic', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

  

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role($role) {
        $role = (array)$role;
        return in_array($this->role, $role);
    }

      public function posts()
    {
        return $this->hasMany('heychum\Post', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('heychum\Comment', 'user_id');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('heychum\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('heychum\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()->
            merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true,
        ]);
    }

    public function isFriendsWith(User $user)
    {
        return $this->friends()->where('id', $user->id)->count();
    }

    // public function likes()
    // {
    //     return $this->hasMany('heychum\Like', 'user_id');
    // }
    // public function hasLikedPost(Post $post)
    // {
    //     return (bool) $post->likes
    //         ->where('likeable_id', $post->id)
    //         ->where('likeable_type', get_class($post))
    //         ->where('user_id', $this->id)
    //         ->count();
    // }
}
