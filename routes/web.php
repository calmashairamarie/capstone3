<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// DONT NEED AUTH


// ROUTES need auth
Route::middleware("auth")->group(function(){
	// Route::get("/profile", function(){
	// 	return view("profile");
	// });
	// SEARCH
	Route::get('/search', 'SearchController@getResults')->name('search.results');

	//PROFILE
	// Route::get("/user/{id}", "ProfileController@getProfile")->name('profile.index');
	Route::get("/user/{id}", "ProfileController@getProfile");
	Route::get('/profile', 'ProfileController@showFriends' );
	Route::get("/profile/edit", "ProfileController@getEdit");
	Route::post("/profile/edit", "ProfileController@postEdit");
	// FRIENDS
	Route::get('/friends', 'FriendController@getIndex')->name('friends.index');
	Route::get('/friends/add/{id}', 'FriendController@getAdd')->name('friends.add');
	Route::get('/friends/accept/{id}', 'FriendController@getAccept')->name('friend.accept');
	// STATUS/POST
	Route::post('/status', 'StatusController@postStatus')->name('status.post');
	Route::post('/status/{statusId}/reply', 'StatusController@postReply')->name('status.reply');
	
	// post with images
	Route::get('/post', 'PostController@index');
	Route::post('/post', 'PostController@store');
	Route::get('/post/show/{id}', 'PostController@show')->name('post.show');
	Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');
	/*edit post*/
	Route::patch("/post/edit/{id}", "PostController@edit");
	Route::delete("/post/delete/{id}", "PostController@destroy");
	// Route::get("/post/like/{id}", "PostController@getLike")->name('post.like');
	Route::post("/post/share/{id}", "PostController@share");

	Route::post('/comment/store', 'CommentController@store')->name('comment.add');
});


// ROUTES FOR ADMIN
Route::group(['middleware' => 'can:accessAdminpanel'], function() {
	Route::get('/admindashboard', 'Adminpanel\Dashboard@index');

});

//ROUTES FOR MEMBER
Route::group(['middleware' => 'can:accessMember'], function() {
	Route::get('/timeline', 'TimelineController@newsfeed');
});

// LOGOUT
Route::get('logout', 'Auth\LoginController@logout');
// ALERT
Route::get('/alert', function(){
	return redirect('home')->with('info', 'You have signed up!');
});

Auth::routes();

// guest
Route::get('/home', 'HomeController@index')->name('home');
