@include('layouts.header')

	<div class="nav clearfix">
		@if (Auth::check())
			{{ HTML::linkAction('logout', 'Logout (' . Auth::user()->email . ')', [], ['class' => 'logout-link']) }}
		@endif
	</div>


	@if(Session::has('flash_notice'))
	<div class="flash_notice">{{ Session::get('flash_notice') }}</div>
	@endif

	@yield('content')

</div>

@include('layouts.footer', ['context' => 'app'])
