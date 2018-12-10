@extends("template.template")

@section("content")
	<h1>Your search for "{{ Request::input('query') }}"</h1>
	@if(!$users->count())
		<p>No results found!</p>
	@else	
	<div class="row">
		<div class="col-lg-12">
			@foreach($users as $user)
				@if ( Auth::user()->id == $user->id )
					@include('user/usercurrent')
				@else						
					@include('user/userblock')
				@endif
			@endforeach
		</div>
	</div>
	@endif
@endsection
