@extends("template.template")

@section("content")
	<div class="row">
		<div class="col-lg-5">
			@include('user.userblock')
			<hr>
		</div>
	</div>
	
	<div class="container-fluid">

		<div class="row">
			<div class="col-lg-12 text-center">
				<img src="{{ $user->profile_pic }}" style="height: 150px;">
				<h1 class="text-center">{{ $user->firstname }} {{ $user->lastname }}</h1>
				@if(Auth::user()->hasFriendRequestPending($user))
					<p>Waiting for {{ $user->firstname }} {{ $user->lastname }} to accept your request</p>
					<a href="/friends/accept/{{ $user->id }}" class="btn btn-primary">Accept friend request</a>
				@elseif(Auth::user()->isFriendsWith($user))
					<h5>You and {{ $user->firstname }} {{ $user->lastname }} are friends</h5>
				@else
					<a href="/friends/add/{{ $user->id }}" class="btn btn-primary">Add as friend</a>
				@endif	
			</div>
		</div>
		<div>

		</div>
		<div class="row">
			<div class="col-lg-12 text-center">
				<div>
					<ul class="uk-child-width-expand nav nav-tabs" uk-tab >
						<li class="uk-active"><a data-toggle="tab" href="#friend">Friends</a></li>
						<li><a data-toggle="tab" href="#mutualfriends">Mutual Friends</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div id="friend" class="tab-pane fade in active text-left">
						@if(!$user->friends()->count())
							<p>{{ $user->firstname }} {{ $user->lastname }} has no friends.</p>
						@else
							@foreach ($user->friends() as $user)
								@if ( Auth::user()->id == $user->id )
									@include('user/usercurrent')
								@else						
									@include('user/userblock')
								@endif
							@endforeach
						@endif
					</div>
					<div id="mutualfriends" class="tab-pane fade">
					
					</div>
				</div>
			</div>

			<!-- <div class="col-lg-4 text-center">
				<h3>Photos</h3>
				<h4>{{ $user->firstname }} {{ $user->lastname }}'s Friends</h4>
			</div>
			<div class="col-lg-4 text-center">
				<h3>Recent Activity</h3>
			</div>
			<div class="col-lg-4 text-center">

				<h3>Favorite Movies</h3>
				<h3>Favorite Songs</h3>
			</div> -->
		</div>
	</div>
	@endsection
