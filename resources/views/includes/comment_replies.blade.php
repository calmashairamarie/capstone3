 @foreach($comments as $comment)
 <div class="display-comment">
       <!--  <strong>{{ $comment->user->name }}</strong>
        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a> -->
        <div class="media">
            <a href="/user/{{$comment->user->id}}" class="pull-left">
                <img class="rounded-circle" src="{{ $comment->user->profile_pic }}" style="width: 65px;" alt="just wait">
            </a>
            <div class="media-body">
                <h8 class="mt-0 font-weight-bold"><a href="/user/{{$comment->user->id}}">{{ $comment->user->firstname }} {{ $comment->user->lastname }}</a></h8>
                <p>{{ $comment->body }}</p>
                
               <!--  <a href="#">Like</a> -->
               
                <!-- <a href="#editcomment">Edit</a>
                <a href="#">Delete</a> -->
                <input type="submit" class="btn btn-link" value="Add Comment" />

              
                 @include('includes.replies', ['comments' => $comment->replies])
                <form method="post" action="{{ route('reply.add') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="comment_body" class="form-control" />
                        <input type="hidden" name="post_id" value="{{ $post_id }}" />
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-warning" hidden />
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach