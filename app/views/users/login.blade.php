@extends('layouts.app')

@section('content')
<h1>Login</h1>

@if (Session::has('flash_error'))
<div class="flash_error">{{ Session::get('flash_error') }}</div>
@endif

<p>If you just want to see what it does, try user <b>matt@matt.com</b> and password <b>password</b>.</p>

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
