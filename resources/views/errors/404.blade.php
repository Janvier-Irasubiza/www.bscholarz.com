
@section('title', 'Page Not found')

<x-error-layout>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>Oops!</h1>
			<h2>Page Can Not Be Found</h2>
			<p>The page you are looking for does not exist, have been removed, had its name changed or is temporarily unavailable</p>
			<a href="{{ route('home') }}">Back to homepage</a>
		</div>
	</div>

</x-error-layout>
