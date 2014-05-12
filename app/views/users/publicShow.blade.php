@extends('layouts.public')

@section('content')
	<h2>Public view for user {{ $user->username }}</h2>

	<h3>Old friends to meet at conf</h3>
	<ul>
		@foreach($user->oldFriends as $friend)
		<li><a href="http://twitter.com/{{ $friend->twitter }}">{{ '@' . $friend->twitter }}</a></li>
		@endforeach
	</ul>

	<h3>New friends met at conf</h3>
	<ul>
		@foreach($user->newFriends as $friend)
		<li><a href="http://twitter.com/{{ $friend->twitter }}">{{ '@' . $friend->twitter }}</a></li>
		@endforeach
	</ul>

@stop