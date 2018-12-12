

@extends("template.template")

@section("content")
@guest
	<div class="container" id="guest">
	    <div class="row" >
	        <div class="col-md-8 col-md-offset-2">
	            <div class="panel panel-default">
	                <div class="panel-heading">Login</div>

	                <div class="panel-body">
	                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
	                        {{ csrf_field() }}

	                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
	                            <label for="username" class="col-md-4 control-label">Username</label>

	                            <div class="col-md-6">
	                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

	                                @if ($errors->has('username'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('username') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	                            <label for="password" class="col-md-4 control-label">Password</label>

	                            <div class="col-md-6">
	                                <input id="password" type="password" class="form-control" name="password" required>

	                                @if ($errors->has('password'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('password') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <div class="col-md-6 col-md-offset-4">
	                                <div class="checkbox">
	                                    <label>
	                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
	                                    </label>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <div class="col-md-8 col-md-offset-4">
	                                <button type="submit" class="btn btn-primary">
	                                    Login
	                                </button>

	                                <a class="btn btn-link" href="{{ route('password.request') }}">
	                                    Forgot Your Password?
	                                </a>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	@else

	<div class="uk-position-relative uk-visible-toggle uk-dark" uk-slideshow>

    <ul class="uk-slideshow-items">
        <li>
            <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" style="background-color: #FFE5D9;">
            		<h1 class="text-center" style="background-color: #FFE5D9;">Social Media</h1>

			</div>
        </li>
        <li>
            <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" style="background-color:  #FFCAD4;">
            	<h1 class="text-center" style="background-color:  #FFCAD4;">You can interact with me, to him and to anyone</h1>
			</div>
			
        </li>
        <li>
             <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" style="background-color:  #F4ACB7;">
             	<h1 class="text-center" style="background-color:  #F4ACB7;">With security and privacy</h1>
			</div>
        </li>
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>

@endguest				
	

@endsection