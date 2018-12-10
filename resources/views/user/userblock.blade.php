<div class="media">
	<a href="/user/{{$user->id}}" class="pull-left">
		<img  class="media-object" src="{{ $user->profile_pic }}">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><a href="/user/{{$user->id}}">{{ $user->firstname }} {{ $user->lastname }}</a></h4>
	</div>
</div>