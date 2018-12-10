 @foreach($comments as $comment)
 <div class="display-comment">
 	<div class="media">
 		<a href="/user/{{$comment->user->id}}" class="pull-left">
 			<img class="rounded-circle" src="{{ $comment->user->profile_pic }}" style="width: 60px" alt="just wait">
 		</a>
 		<div class="media-body">
 			<h9 class="mt-0 font-weight-bold"><a href="/user/{{$comment->user->id}}">{{ $comment->user->firstname }} {{ $comment->user->lastname }}</a></h9>
 			<p>{{ $comment->body }}</p>
 			<a href="#">Like</a>

 			<a href="#">Edit</a>
 			<a href="#">Delete</a>
 		</div>
 	</div>
 </div>
 @endforeach