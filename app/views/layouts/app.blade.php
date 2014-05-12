@include('layouts.header')

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

@include('layouts.footer', ['context' => 'app'])