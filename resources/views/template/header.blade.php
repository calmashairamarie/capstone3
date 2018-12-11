<nav class="uk-navbar-container uk-margin" uk-navbar id="mynav" style="background-color: #F7D9CF;">
	<div class="uk-navbar-left">
		<a class="uk-navbar-item uk-logo" href="{{ route('home') }}">Social Media</a>
	</div>


	<div class="uk-navbar-right">
		
		<div class="uk-navbar-item">
			<form class="navbar-form" action="{{ route('search.results') }}" role="search">
				<div class="row">
					<div class="form-group">
						<input style="height: 30px;" name="query" class="uk-input form-control" type="text" placeholder="Find people">
					</div>
					<button style="height: 30px;" type="submit" class="uk-button uk-button-default">Search</button>
				</div>
			</form>
		</div>

		<ul class="uk-navbar-nav">

			@guest
				<li><a href="{{ route('login') }}">Login</a></li>
				<li><a href="{{ route('register') }}">Register</a></li>
				@else
				<li class="dropdown">
					<a href="/profile" class="dropdown-toggle" data-toggle="dropdown" role="button" v-pre>
						{{ Auth::user()->username }} <!-- <span class="caret"></span> -->
					</a>
					<ul class="dropdown-menu text-center">
						<li>
							<a href="/profile">Profile</a>
						</li>
						
						<li>
							<a href="/profile/edit">Edit Profile</a>
						</li>
						<li>
							<a href="{{ route('logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							Logout
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>

				<ul class="uk-navbar-nav">
				<li>
					<a href="/home">
						<span class="uk-icon uk-margin-small-right" uk-icon="icon: home"></span>
						Home
					</a>
				</li>
			</ul>
			<ul class="uk-navbar-nav">
				<li>
					<a href="/post">
						<span class="uk-icon uk-margin-small-right"><i class="far fa-lg fa-newspaper"></i></span>
						Post
					</a>
				</li>
			</ul>
			@endguest

		</ul>


</nav>