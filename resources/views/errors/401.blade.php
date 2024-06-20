
@section('title', 'Access denied')

<x-error-layout>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>Oops!</h1>
			<h2>Access denied</h2>
			<p>You do not have permission to access this resource.</p>
			<a href="{{ route('home') }}">Back to homepage</a>
		</div>
	</div>

</x-error-layout>
