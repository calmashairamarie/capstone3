<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends("template.template")

@section("content")
<div class="container">
	
	<!-- <div class="col-sm-3">s</div> -->
	<div class="col-sm-8 col-sm-offset-2">
		<form method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
						<input type="text" name="title" class="form-control" placeholder="Enter your post title">
						@if ($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group">
						<textarea name="body" class="form-control" rows="8" cols="100"></textarea>
					</div>
					<div class="form-group">
						<input type="file" class="form-control" name="image">
					</div>

					<input type="submit" value="Post" class="btn btn-primary btn-block">
				</div>
			</div>
		</form>

		@foreach($posts as $post)


		@if($post->shared_id != null)
		<div class="panel panel-default">
			<div class="panel-heading">
				@if ( Auth::user()->id == $post->user->id )
				<a href="/profile" class="pull-left">
					<img class="rounded-circle" src="{{ $post->user->profile_pic }}">
				</a>
				@else
				<a href="/user/{{$post->user->id}}" class="pull-left">
					<img class="rounded-circle" src="{{ $post->user->profile_pic }}">
				</a>
				@endif

				<span class="pull-right">{{ $post->created_at->diffForHumans() }}</span>
				<h5><a href="">  {{ $post->user->firstname }} {{ $post->user->lastname }}</a></h5>
				<h4>  {{ $post->title }}</h4>
			</div>
			<div class="panel-body text-justify">

				@if($post->shared_image != null)
				<img src="images/{{ $post->shared_image }}" alt="image">
				@endif
				<button class="btn btn-md btn-default "  style="width: 95%; font-size: 12px;" type="button">Credits to {{$post->shared_name}}</button>
				<p>{{$post->body}}</p>
				<form method="post" action="{{ route('comment.add') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="hidden" name="post_id" value="{{ $post->id }}" />
					</div>
					<div class="form-group">
						<a href="/post/like/{{$post->id}}" class="btn btn-link">Like {{$post->likes->count()}} likes</a>
						<input type="submit" hidden/>
						<button type="button" class="btn btn-link" id="showCommentbox2" type="button" onClick="showcomment2({{ $post->id }})">Comment</button>
						@if( $post->image != null || $post->shared_image !=null)
						<button type="button" data-toggle="modal" data-target="#sharepost-{{$post->id}}" class="btn btn-link">Share photo</button>
						@endif
						<a href="{{ route('post.show', $post->id) }}" class="btn btn-link">Show Post</a>
					</div>
					<div class="form-group">
						<div id="comments_box2_{{ $post->id }}" style="display: none;">
							<input placeholder="Write something here" type="text"  class="form-control" name="comment_body" />
						</div>
					</div>
				</form>
			</div>
			<div class="panel-footer text-right">
				<button class="btn btn-link" id="showMore" type="button" onClick="show({{ $post->id }})">View comments</button>
				<div class="text-justify" id="comments_section_{{ $post->id }}" style="display: none;">
					@include('includes.comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
				</div>
			</div>
		</div>
		@else
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
				<div class="">
					<p>{{ $post->body }}</p>
				</div>
			</div>
			<div class="panel-footer">
				<form method="post" action="{{ route('comment.add') }}">
					{{ csrf_field() }}
					 <div class="form-group">
						<a href="/post/like/{{$post->id}}" class="btn btn-link">Like {{$post->likes->count()}}</a>
						 <button type="button" class="btn btn-link" id="showCommentbox" type="button" onClick="showcomment({{ $post->id }})">Comment</button>

						 <span class="text-right">{{ $post->created_at->diffForHumans() }}</span> 
						 @if( $post->image != null || $post->shared_image !=null)
							<button type="button" data-toggle="modal" data-target="#sharepost-{{$post->id}}" class="btn btn-link">Show photo</button>
						@endif
						
						<a href="{{ route('post.show', $post->id) }}" class="btn btn-link">Show Post</a>
					</div> 
					<div class="form-group">
						<div id="comments_box_{{ $post->id }}" style="display: none;">
							<input placeholder="Write something here" type="text" name="comment_body" class="form-control" />
						</div>
						<input type="hidden" name="post_id" value="{{ $post->id }}" />
					</div>
					<input type="submit" hidden />
				</form>
				<button class="btn-link" id="showMore" type="button" onClick="show({{ $post->id }})">View comments</button>
				<span class="text-right">{{ $post->created_at->diffForHumans() }}</span>
				<div id="comments_section_{{ $post->id }}" style="display: none;">
					@include('includes.comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
				</div>
			</div>
		</div>	
		<div class="modal fade" id="sharepost-{{$post->id}}" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<span></span>
						<h4 class="modal-title w-100" id="myModalLabel" >Show this photo</h4>
						<button type="button" class="close" data-dismiss="modal">
							<span>&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<form>
							<input type="text" name="shared_name" id="shared_name_{{$post->id}}" value="{{$post->user->firstname}} {{$post->user->lastname}}" hidden>
							<input type="text" name="shared_image" id="shared_image_{{$post->id}}" value="{{$post->image}}" hidden>
							<input type="text" name="post_title" id="post_title_{{$post->id}}" placeholder="Title" class="form-control">

							@if($post->image != null)						
							<img src="images/{{ $post->image }}" alt="image" width="100%" height="600">
							@endif

							<input type="text" name="post_body" id="post_body_{{$post->id}}" placeholder="Body" class="form-control">
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>
						<!-- <button type="button" onclick="shared({{$post->id}})" data-id="{{ $post->id }}" class="btn btn-primary btn-md">Share</button> -->
					</div>
				</div>
			</div>
		</div>
		@endif
		@endforeach
	</div>
</div>
<script type="text/javascript">
	function show(id){
		$('#comments_section_'+id).css('display', 'block');
	}
	function showcomment(id){
		$('#comments_box_'+id).css('display', 'block');
	}
	function showcomment2(id){
		$('#comments_box2_'+id).css('display', 'block');
	}
</script>

<script type="text/javascript">
	function shared(id){

		let post_title = $("#post_title_"+id).val();
		let post_body = $("#post_body_"+id).val();
		let shared_title = $("#shared_title_"+id).val();
		let shared_name = $("#shared_name_"+id).val();
		let shared_image = $("#shared_image_"+id).val();
		let shared_body = $("#shared_body_"+id).val();
		$.ajax({
			url : "/post/share/"+id,
			type : "POST",
			data : {
				post_title : post_title,
				post_body : post_body,
				shared_title : shared_title,
				shared_name : shared_name,
				shared_image : shared_image,
				shared_body : shared_body,
				_method : "POST",
				_token : "{{ csrf_token() }}"
			},
			success : function(data){
				console.log(data);
			}
		});
	}
</script>
@endsection



