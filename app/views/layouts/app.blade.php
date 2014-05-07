<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>M347</title>

	<meta name="description" content="Connecting cyberspace with meatspace, one conference at a time.">
	<meta name="author" content="Matt Stauffer">
	<meta name="viewport" content="width=device-width">

	<style>
		.page-title {
			margin-bottom: 0;
		}
		.slogan {
			font-style: italic;
			margin: 0.5rem 0 1rem 0;
			text-transform: uppercase;
		}
		.friends-list-container {

		}
			.friends-list-container li {

			}
				.friends-list-container li div {
					display: inline-block;
				}
		.old-friends-list-container .marked-as-met,
			.old-friends-list-container .marked-as-met a {
			color: #555;
		}
			.marked-as-met button.mark-as-met {
				opacity: .4;
			}

		.new-friends-list-container button.mark-as-met {
			display: none;
		}

	</style>
</head>
<body>
<div class="container">
	<h1 class="page-title">m347</h1>
	<p class="slogan">Connecting cyberspace with meatspace, one conference at a time.</p>

	<div class="nav">
		@if (Auth::check())
		<ul>
			<li>{{ HTML::linkAction('logout', 'Logout (' . Auth::user()->email . ')') }}</li>
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
