

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
	<div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light"
     data-src="https://images.unsplash.com/photo-1490822180406-880c226c150b?fit=crop&w=650&h=433&q=80"
     data-srcset="https://images.unsplash.com/photo-1490822180406-880c226c150b?fit=crop&w=650&h=433&q=80 650w,
                  https://images.unsplash.com/photo-1490822180406-880c226c150b?fit=crop&w=1300&h=866&q=80 1300w"
     data-sizes="(min-width: 650px) 650px, 100vw" uk-img>
    <h1>SOcial Media</h1>
</div>
@endguest				
	

@endsection