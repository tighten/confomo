@extends('layouts.app')

@section('content')

<div class="friends-list-container old-friends-list-container" id="old-friends" data-type="old">
	<h2>Friends I want to Meet at the Conference</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem" class="submit-friend">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<div class="friends-list-container new-friends-list-container" id="new-friends" data-type="new">
	<h2>Friends I Met at the Conference And Want to Remember</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem" class="submit-friend">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<script type="text/html" id="person-template">
	<li data-bind="css: { 'marked-as-met': met() == 1, 'suggested': type().indexOf('suggested') > -1 }" class="media friends-list-item">
		<div class="friend-list-item__image">
			<img data-bind="attr: { src: twitter_profile_pic }" class="friend-list-item__image">
		</div>
		<div class="friend-list-item__body">
			<div>
				<span data-bind="text: first_name + ' ' + last_name"></span>
				<a href="#" data-bind="text: '@' + twitter, attr: { href: 'http://twitter.com/' + twitter }"></a>
			</div><br>
		</div>
		<div class="friend-list-item__actions">
			<a href="#" class="button friend-list-item__action approve-suggested" data-bind="click: approveSuggested">Add Suggested</a>
			<a href="#" class="button friend-list-item__action mark-as-met" data-bind="click: markThisItemMet">Mark met</a>
			<a href="#" class="button friend-list-item__action destroy" data-bind="click: $root.remove">Remove</a>
		</div>
	</li>
</script>

<br><br><br>
<h2>@todo</h2>
<ul>
	<li><strike>Add user login</strike></li>
	<li><strike>Scope tasks to user</strike></li>
	<li><strike>Allow checking someone off as "met"</strike></li>
	<li><strike>Allow users to sign up</strike></li>
	<li>Move @todo to github issues</li>
	<li><strike>Pull profile from Twitter</strike></li>
	<li><strike>Show twitter profile pic</strike></li>
	<li><strike>Use real queue for twitter profile pic</strike></li>
	<li>Optimize twitter pull to not duplicate pulls, re-pull after __ time on cron, etc.</li>
	<li>Make suggested friend fail ENTIRELY on bad twitter, not just fail to pull profile pic</li>
	<li>Display first name, last name, other stuff</li>
	<li>Add some sort of IRC love?</li>
	<li>Add rate limiting &amp; email address validation</li>
	<li>Add notes for how you met someone</li>
	<li>Make it not hideous</li>
	<li>Add loading graphics</li>
	<li>Force twitter handle to be proper twitter handle</li>
	<li>Auto-fill details based on twitter handle</li>
	<li>Make lists public (but notes private?)</li>
	<li>Some other form of community participation</li>
	<li>CHORES</li>
	<li>Consolidate error handling in user create</li>
	<li>Drop Authority because we're clearly not using it</li>
</ul>
@stop
