@extends("template.template")

@section("content")
	<div class="row">
		<div class="col-lg-6">
			<h3>Your Friends</h3>

			@if(!$friends->count())
				<p>You have no friends.</p>
			@else
				@foreach ($friends as $user)
					@include('user/userblock')
				@endforeach
			@endif
		</div>
		<div class="col-lg-6">
			<h3>Friend requests</h3>

			@if(!$requests->count())
				<p>You have no friend requests.</p>
			@else
				@foreach ($requests as $user)
					@include('user/userblock')
				@endforeach
			@endif
		</div>
	</div>
@endsection