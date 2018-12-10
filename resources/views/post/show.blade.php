<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends("template.template")

@section('content')
<div class="col-sm-6 col-sm-offset-3">
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
            <img src="/images/{{ $post->image }}" alt="image" width="100%" height="600">
            @endif
            <div class="media-body">
                <p>{{ $post->body }}</p> 
            </div>
        </div>
        <div class="panel-footer">
            <form method="post" action="{{ route('comment.add') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="row">
                        <a href="#" class="btn btn-link"><i class="far fa-thumbs-up fa-2x"></i></a>
                      <!--   <a href="#" class="btn btn-link">{{$post->likes->count()}} Like </a> -->
                        <!-- <a href="#" class="btn btn-link"></a> -->

                        <!-- <span class="text-right">{{ $post->created_at->diffForHumans() }}</span> -->
                        @if(Auth::user()->id == $post->user_id)
                        <a href="#" data-toggle="modal" data-target="#editpost" class="btn btn-link">Edit</a>
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#confirmDelete">Delete</a>
                        @endif
                        <input type="submit" class="btn btn-link" value="Comment" />
                        <!-- <a href="{{ route('post.show', $post->id) }}" class="btn btn-link">Show Post</a> -->
                    </div>
                </div>
                <div class="form-group">
                    <input placeholder="comment to this" type="text" name="comment_body" class="form-control" />
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                </div>
            </form>
            @include('includes.comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
        </div>  
    </div>
</div>  



  @endsection
<!-- EDIT MODAL -->
<div class="modal fade" id="editpost" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="post" action="/post/edit/{{$post->id}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field("PATCH") }}
            <div class="modal-header">
                <span></span>
                <h4 class="modal-title w-100" id="myModalLabel">Edit</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            Title: <input type="text" id="title" name="title" class="form-control" value="{{$post->title}}">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <!--<img src="/images/{{$post->image}}">
                                <input type="file" class="form-control" name="image"> -->
                                <img id="img" src="/images/{{$post->image}}"  style="width: 800px; height: 600px;" alt="your image" />
                                <input name="image" type='file' id="image" onChange="readURL(this);"/>
                                @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input  class="form-control" type="text" name="body" id="body" value="{{ $post->body }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-secondary btn-md">Update</button>
              </div>
          </form>
      </div>
  </div>
</div>
<!-- DELETE MODAL -->
<div class="modal fade" id="confirmDelete" tabindex="-1">
    <div class="modal-dialog modal-sm modal-notify modal-danger">
       <div class="modal-content text-center">
                   <div class="modal-header">
                     <p class="heading">Are you sure?</p>
                  </div>
              
               <div class="modal-footer">
                  <form method="POST" action="/post/delete/{{$post->id}}">
                        {{ csrf_field() }}
                        {{ method_field("DELETE") }}
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
                  </form>
            </div>
        </div>
    </div>
</div>




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
