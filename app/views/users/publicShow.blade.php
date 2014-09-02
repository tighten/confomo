@extends('layouts.public')

@section('content')
	<h2>Public view for user {{ $user->username }} at conference {{ $conference->name }}</h2>

	<div id="old-friends" data-type="old">
		<h3>Old friends to meet at conf</h3>
		<i>(Grey = met)</i>
		<ul class="public-list">
			@foreach($conference->oldFriends as $friend)
			<li style="clear: both;" class="{{ $friend->met ? 'public-mark-as-met' : '' }}">
				<img src="/{{ $friend->twitter_profile_pic }}" class="friend-list-item__image">
				<a href="http://twitter.com/{{ $friend->twitter }}" target="_blank">
					{{ '@' . $friend->twitter }}
				</a>
			</li>
			@endforeach
		</ul>

		<form data-bind="submit: addItem" style="clear: both; padding-top: 1rem;">
			<label for="suggestOldFriend">Suggest old friend for `{{ $user->username }}` to meet:</label><br>
			@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
			<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
			<div class="addItem-message"></div>
		</form>
	</div>

	<div id="new-friends" data-type="new">
		<h3>New friends met at conf</h3>
		<ul class="public-list">
			@foreach($conference->newFriends as $friend)
			<li style="clear: both;" class="{{ $friend->met ? 'public-mark-as-met' : '' }}"><img src="/{{ $friend->twitter_profile_pic }}" class="friend-list-item__image"><a href="http://twitter.com/{{ $friend->twitter }}">{{ '@' . $friend->twitter }}</a></li>
			@endforeach
		</ul>

		<form data-bind="submit: addItem" style="clear: both; padding-top: 1rem;">
			<label for="suggestOldFriend">Suggest new friend for `{{ $user->username }}` to track as "met":</label><br>
			@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
			<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
			<div class="addItem-message"></div>
		</form>
	</form>
	</div>
@stop
