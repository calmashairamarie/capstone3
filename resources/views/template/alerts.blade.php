
@if (Session::has('info'))
	<div class="alert alert-info" role="alert">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		{{ Session::get('info') }}
	</div>
@endif