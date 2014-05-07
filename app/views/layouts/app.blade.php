<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>M347</title>

	<!--

	You are here. You are 1337.
	m347 is for connecting your cyberspace world to the meatspace world by
	connecting social media/IRC friends with conference co-attendees and vice
	versa. Because I wanted it for myself, so I built it.

	Matt Stauffer - mattstauffer.co - @stauffermatt

        ____________
	   /\  ________ \
      /  \ \______/\ \
     / /\ \ \  / /\ \ \
    / / /\ \ \/ / /\ \ \
   / / /__\ \ \/_/__\_\ \__________
  / /_/____\ \__________  ________ \
  \ \ \____/ / ________/\ \______/\ \
   \ \ \  / / /\ \  / /\ \ \  / /\ \ \
    \ \ \/ / /\ \ \/ / /\ \ \/ / /\ \ \
     \ \/ / /__\_\/ / /__\ \ \/_/__\_\ \
      \  /_/______\/_/____\ \___________\
      /  \ \______/\ \____/ / ________  /
     / /\ \ \  / /\ \ \  / / /\ \  / / /
    / / /\ \ \/ / /\ \ \/ / /\ \ \/ / /
   / / /__\ \ \/_/__\_\/ / /__\_\/ / /
  / /_/____\ \_________\/ /______\/ /
  \ \ \____/ / ________  __________/
   \ \ \  / / /\ \  / / /
    \ \ \/ / /\ \ \/ / /
     \ \/ / /__\_\/ / /
      \  / /______\/ /
       \/___________/BvG

       ( via http://www.chris.com/ascii/index.php?art=objects/boxes )

	-->

	<meta name="description" content="Connecting cyberspace with meatspace, one conference at a time.">
	<meta name="author" content="Matt Stauffer">
	<meta name="viewport" content="width=device-width">

	<style>
		input, input[type="text"], input[type="email"] {
			font-size: 16px;
		}

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
