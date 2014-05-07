@extends('layouts.app')

@section('content')
<h1>Login</h1>

@if (Session::has('flash_error'))
<div class="flash_error">{{ Session::get('flash_error') }}</div>
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

<p>{{ Form::submit('Login') }}</p>

{{ Form::close() }}

<br>

{{ HTML::linkAction('signup', 'Sign up') }}
@stop
