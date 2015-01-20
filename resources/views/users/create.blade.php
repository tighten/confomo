@extends('layouts.app')

@section('content')
<h1>Sign up</h1>

@if (Session::has('flash_error'))
<div class="flash_error">{{ Session::get('flash_error') }}</div>
@endif
@if ($errors->has())
<ul class="error">
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
</ul>
@endif

{{ Form::open() }}

<p>
	{{ Form::label('email', 'Email') }}<br/>
	{{ Form::email('email', Input::old('email')) }}
</p>

<p>
	{{ Form::label('password', 'Password') }}<br/>
	{{ Form::password('password') }}
</p>

<p>
	{{ Form::label('username', 'Username (for URL use in public list sharing)') }}<br/>
	{{ Form::text('username', Input::old('username')) }}
</p>

<p>{{ Form::submit('Sign Up') }}</p>

{{ Form::close() }}

<br>

{{ Html::linkRoute('login', 'Log in') }}
@stop
