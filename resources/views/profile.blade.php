<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends("template.template")

@section("content")
<div class="container-fluid">
	
	<div class="row">
		<div class="col-lg-12 text-center">
			<img src="{{ Auth::user()->profile_pic }}" style="height: 150px;">
			<h1 class="text-center">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-9">
			<div>
				<ul class="uk-child-width-expand nav nav-tabs" uk-tab >
					<li class="uk-active"><a data-toggle="tab" href="#posts">Posts</a></li>
					<li class="text-center"><a data-toggle="tab" href="#comments">Comments</a></li>
<!-- 					<li class="text-center"><a data-toggle="tab" href="#likes">Liked</a></li> -->
					<li class="text-center"><a data-toggle="tab" href="#tags">Tags</a></li>
					<li class="text-center"><a data-toggle="tab" href="#shared">Shared</a></li>
					<li class="text-center"><a data-toggle="tab" href="#friend">friend</a></li>
					<li class="text-center"><a data-toggle="tab" href="#photo">Photos</a></li>
				</ul>
			</div>
			<div class="tab-content ">

				<div id="posts" class="tab-pane fade in active">
					<div class="col-sm-8 col-sm-offset-2">
						@foreach($userposts as $post)
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
								<form method="post" action="{{ route('comment.add') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<input type="hidden" name="post_id" value="{{ $post->id }}" />
									</div>
									<div class="form-group">
										<!-- <a href="#" class="btn btn-link btn-md">Like</a>
										<a href="#" class="btn btn-link btn-md">Dislike</a> -->

										<input type="submit" hidden>

										<button type="button" class="btn btn-link btn-md" id="showCommentbox" type="button" onClick="showcomment({{ $post->id }})">Comment</button>


										<a href="{{ route('post.show', $post->id) }}" class="btn btn-link btn-md">Show Post</a>
									</div> 
									<div class="form-group">
										<div id="comments_box_{{ $post->id }}" style="display: none;">
											<input placeholder="Write something here" type="text" name="comment_body" class="form-control" />
										</div>
									</div>
								</form>

								<button class="btn-link" id="showMore" type="button" onClick="show({{ $post->id }})">View comments</button>

								<!-- <a type="submit" href="#show({{ $post->id }})">View comments</a> -->

								<span class="text-right">{{ $post->created_at->diffForHumans() }}</span>

								<div id="comments_section_{{ $post->id }}" style="display: none;">
									@include('includes.comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
								</div>

							</div>
						</div>	
						@endforeach
					</div>
				</div>
				<div id="comments" class="tab-pane fade">
					<!-- <div class="col-sm-7 col-sm-offset-3"> -->

						@foreach(Auth::user()->comments as $comment)

						@if($comment->comment_id != null)
						<p>You commented <strong> {{ $comment->body }}</strong> to this
							<a href="{{ route('post.show', ($post->id = $comment->commentable_id)) }} ">Post</a> </p>
							@else
							<p>You replied <strong> {{ $comment->body }}</strong> to 
								@if(Auth::user()->id == $comment->user_id)
								<span>your comment at this <a href="{{ route('post.show', $comment->commentable_id) }} ">Post</a></span>
								@else
								{{ $comment->user->firstname }}
								@endif
						@endif
						@endforeach
					<!-- </div> -->
				</div>
				<!-- <div id="likes" class="tab-pane fade">
					<h3>Likes</h3>
					<p></p>
					<a href=""></a>
				</div> -->
				<div id="tags" class="tab-pane fade">
					<h3>Tagss</h3>
					<p></p>
				</div>
				<div id="shared" class="tab-pane fade">
					<div class="col-sm-12">
						<div class="card-deck">
							@foreach($userposts as $post)
							@if($post->shared_image != null)
							<div class="col-sm-4">	
								<div class="card" style="margin-top: 20px;">
									<div class="card-body">
										<a href="/post/show/{{$post->shared_id}}"><img src="images/{{$post->shared_image}}"></a>
									</div>
								</div>		
							</div>			
							@endif
							@endforeach
						</div>
					</div>
				</div>

				<div id="friend" class="tab-pane fade">
					<div class="col-sm-12">
						<div class="card-deck">
							@if(!$friends->count())
						<p>You have no friends.</p>
						@else
						@foreach ($friends as $user)

						<a href="/user/{{$user->id}}" class="pull-left">
							<img  class="media-object" src="{{ $user->profile_pic }}">
						</a>

						@endforeach
						@endif
						</div>
					</div>
					<div class="col-lg-12 text-right">
						<a href="/friends">View more</a>
					</div>
					<div class="col-lg-12">

					</div>
				</div>


				<div id="photo" class="tab-pane fade">
					<div class="col-sm-12">
						</div>
							<h3>Photos</h3>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- <div class="col-lg-3 text-center">
			<h3>Recent Activity</h3>
		</div>
		<div class="col-lg-3 text-center">

			<h3>Favorite Movies</h3>
			<h3>Favorite Songs</h3>
		</div> -->
	</div>
</div>
@endsection

<script type="text/javascript">
	function show(id){
		$('#comments_section_'+id).css('display', 'block');
	}
	function show2(id){
		$('#comments_section2_'+id).css('display', 'block');
	}
	function showcomment(id){
		$('#comments_box_'+id).css('display', 'block');
	}
	function showcomment2(id){
		$('#comments_box2_'+id).css('display', 'block');
	}
	function showcomment3(id){
		$('#comments_box3_'+id).css('display', 'block');
	}
	function showcomment4(id){
		$('#comments_box4_'+id).css('display', 'block');
	}

</script>