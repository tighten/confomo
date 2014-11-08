@include('layouts.header')

	@yield('content')

@include('layouts.footer', ['context' => 'public'])
