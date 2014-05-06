<!DOCTYPE html>
<html>
<head>
	<title>M347</title>
</head>
<body>
<div class="container">
	<h1>m347</h1>
	<div class="nav">
		@if (Auth::check())
		<ul>
			<li>{{ HTML::linkAction('logout', 'Logout (' . Auth::user()->username . ')') }}</li>
		</ul>
		@endif
	</div>

	@if(Session::has('flash_notice'))
	<div class="flash_notice">{{ Session::get('flash_notice') }}</div>
	@endif

	@yield('content')

</div>

<script src="bower_components/jquery/dist/jquery.js"></script>
<script src="bower_components/component-knockout-passy/knockout.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
