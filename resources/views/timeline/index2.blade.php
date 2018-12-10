@extends('layouts.app')

@section("content")
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Post</div>
                <div class="card-body">
                    <form method="post" action="{{ route('post.store') }}">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <label class="label">Post Title: </label>
                            <input type="text" name="title" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label class="label">Post Body: </label>
                            <textarea name="body" rows="10" cols="30" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" />
                        </div>
                    </form>

                    @foreach($posts as $post)
                    <div class="panel panel-default">
                    	<div class="panel-heading">
                    		<div class="media">
                    			@if ( Auth::user()->id == $post->user->id )
                    			<a href="/profile" class="pull-left">
                    				<img class="media-object" src="{{ $post->user->profile_pic }}">
                    			</a>
                    			@else
                    			<a href="/user/{{$post->user->id}}" class="pull-left">
                    				<img class="media-object" src="{{ $post->user->profile_pic }}">
                    			</a>
                    			@endif
                    			<div class="media-heading">
                    				<h4><a href="">{{ $post->user->firstname }} {{ $post->user->lastname }}</a></h4>
                    				<h3>{{ $post->title }}</h3>
                    			</div>					
                    		</div>	
                    	</div>
                    	<div class="panel-body">
                    		@if($post->image != null)
                    		<img src="images/{{ $post->image }}" alt="image" width="100%" height="600">
                    		@endif
                    		<div class="media-body">
                    			<p>{{ $post->body }}</p>
                    		</div>
                    	</div>
                    	<div class="panel-footer">
                    		<a href="#" class="btn btn-link">Like</a>
                    		<a href="#" class="btn btn-link">Dislike</a>
                    		<a href="#" class="btn btn-link">Comment</a>
                    		<span class="text-right">{{ $post->created_at->diffForHumans() }}</span>
                    	</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

