<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>@yield('title', 'Confomo')</title>

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
		body {
			background: #555;
			font-family: arial;
			margin: 0;
			padding: 0;
		}
		img {
			max-width: 100%;
		}
		input, input[type="text"], input[type="email"] {
			font-size: 16px;
		}
		.container {
			background: #fff;
			margin: 0 auto;
			max-width: 800px;
			padding: 1rem 2rem;
		}
		.page-header {
			background: #eee;
			margin: -1rem -2rem 1rem;
			padding: 1rem 2rem 0.5rem;
		}
		.page-title, .slogan {
			font-family: 'Menlo', 'Courier New', 'Courier';
		}
		.page-title {
			margin: 0;
		}
			.page-title span {
				font-size: 1rem;
				font-style: italic;
			}
		.slogan {
			font-style: italic;
			margin: 0.5rem 0 1rem 0;
			text-transform: uppercase;
		}
		.nav ul {
			margin: 0;
			padding: 0;
		}
			.nav li {
				display: inline-block;
				list-style-type: none;
				padding: 0;
				margin: .5rem 1rem;
			}

		h2 {
			background: #eee;
			margin-left: -0.5rem;
			margin-right: -0.5rem;
			padding: 0.5rem 0.5rem 0.25rem;
		}

		.friends-list-container {

		}
			.friends-list-container ul {
				list-style-type: none;
				padding-left: 0;
			}
				.friends-list-container li div {
					display: inline-block;
				}

		@media only screen and (min-width: 500px) {
			.friends-list-container ul {
				padding-left: 1em;
			}
		}
		.old-friends-list-container .marked-as-met,
			.old-friends-list-container .marked-as-met a {
			color: #999;
		}
			.marked-as-met button.mark-as-met {
				opacity: 0.4;
			}
			.marked-as-met img {
				opacity: 0.4;
			}

		.new-friends-list-container button.mark-as-met {
			display: none;
		}

		/* ====== media ====== */
		.media {
			margin: 10px;
		}
		.media, .media-body {
			overflow: hidden;
			_overflow: visible;
			zoom: 1;
		}
		.media-img {
			float: left;
			margin-right: 10px;
		}
		.media-img img {
			display: block;
		}
		/*.media .imgExt{float:right; margin-left: 10px;}*/

	</style>
</head>
<body>
<div class="container">
	<header class="page-header">
		<h1 class="page-title">Confomo</span></h1>
		<p class="slogan">Connecting your online community with the real world, one conference at a time.</p>
	</header>