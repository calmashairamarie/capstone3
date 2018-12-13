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
               
                <!-- <a href="#editcomment">Edit</a> -->
                <a href="#commentDelete{{$comment->id}}" data-toggle="modal" data-target="#commentDelete{{$comment->id}}">Delete</a>
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



<div class="modal fade" id="commentDelete{{$comment->id}}" tabindex="-1">
    <div class="modal-dialog modal-sm modal-notify modal-danger">
       <div class="modal-content text-center">
                   <div class="modal-header">
                     <p class="heading">Are you sure?</p>
                  </div>
                   <div class="modal-body">
                     <h4>to DELETE this comment?</h4>
                  </div>
              
               <div class="modal-footer">
                  <form method="POST" action="/comment/delete/{{$comment->id}}">
                        {{ csrf_field() }}
                        {{ method_field("DELETE") }}
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <a type="button" class="btn waves-effect" data-dismiss="modal">No</a>
                  </form>
            </div>
        </div>
    </div>
</div>
    @endforeach
   



  <script type="text/javascript">
    function readURL(input){
        let existingimg = "{{$post->image}}";
        var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }else{
         $('#img').attr('src', '/images/'+existingimg);
     }
 }
</script>
