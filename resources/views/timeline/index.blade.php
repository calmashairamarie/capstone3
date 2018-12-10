<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends("template.template")

@section("content")
	<div class="row">
		<div class="col-lg-3">
			<h3>Suggested Friends</h3>
		</div>
		<div class="col-lg-6">
			<form role="form" action="{{ route('status.post') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">		
					<textarea placeholder="You've got to post something {{ Auth::user()->firstname }}" name="status" class="form-control" rows="2"></textarea>
					@if ($errors->has('status'))
					<span class="help-block">
						<strong>{{ $errors->first('status') }}</strong>
					</span>
					@endif
				</div>
				<button type="submit" class="btn btn-default">Post</button>
			</form>
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-3">
			
		</div>
		<div class="col-lg-6">
			<!-- timeline statuses and replies -->
			@if(!$statuses->count())
				<p>There's nothing in your timeline,  yet.</p>
			@else
				@foreach($statuses as $status)
				<div class="media">
					@if ( Auth::user()->id == $status->user->id )
					<a href="/profile" class="pull-left">
						<img class="media-object" src="{{ $status->user->profile_pic }}">
					</a>
					@else
					<a href="/user/{{$status->user->id}}" class="pull-left">
						<img class="media-object" src="{{ $status->user->profile_pic }}">
					</a>
					@endif
					<div class="media-body">
						
						<h4 class="media-heading"><a href="/user/{{$status->user->id}}">{{ $status->user->firstname }} {{ $status->user->lastname }}</a></h4>
						<p>{{ $status->body }}</p>
						<ul class="list-inline">
							<li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
							<li class="list-inline-item"><a href="#">Like</a></li>
							<li class="list-inline-item">10 likes</li>
						</ul>
						<form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has("reply-{$status->id}") ? 'has-error': '' }}">
								<textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
								@if ($errors->has("reply-{$status->id}"))
								<span class="help-block">
									<strong>{{ $errors->first("reply-{$status->id}") }}</strong>
								</span>
								@endif
							</div>
							<input type="submit" value="Reply" class="btn btn-default btn-sm"> 
						</form>

						@foreach($status->replies as $reply)
						<div class="media">
							@if ( Auth::user()->id == $reply->user->id )
							<a href="/profile" class="pull-left">
								<img class="media-object" src="{{ $reply->user->profile_pic }}">
							</a>
							@else
							<a href="/user/{{$reply->user->id}}" class="pull-left">
								<img class="media-object" src="{{ $reply->user->profile_pic }}">
							</a>
							@endif
							<div class="media-body">
								<h4 class="media-heading"><a href="">{{ $reply->user->firstname }} {{ $reply->user->lastname }}</a></h4>
								<p>{{ $reply->body }}</p>
								<ul class="list-inline">
									<li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
									<li class="list-inline-item"><a href="#">Like</a></li>
									<li class="list-inline-item">10 likes</li>
								</ul>
							</div>
						
						</div>
						@endforeach

						

					</div>
				</div>
				@endforeach
				<div class="text-center">
					<?php echo $statuses->render(); ?>
				</div>
			@endif
		</div>
	</div>
@endsection

