@extends('layouts.app')

@section('content')
<div class="friends-list-container old-friends-list-container" id="old-friends" data-type="old">
	<h2>Friends I want to Meet at the Conference</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<div class="friends-list-container new-friends-list-container" id="new-friends" data-type="new">
	<h2>Friends I Met at the Conference And Want to Remember</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' type="text" autocorrect="off" autocapitalize="off">
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<script type="text/html" id="person-template">
	<li data-bind="css: { 'marked-as-met': met() == 1 }">
		<div class="user-list-actions">
			<button class="mark-as-met" data-bind="click: markThisItemMet">met</button>
			<button class="destroy" data-bind="click: $root.remove">x</button>
		</div>
		<div>
			<span data-bind="text: first_name + ' ' + last_name"></span>
			<a href="#" data-bind="text: '@' + twitter, attr: { href: 'http://twitter.com/' + twitter }"></a>
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
	<li>Direct Inject models into controllers so PMJones doesn't make us the next object of his scorn</li>
	<li>Add first name, last name, profile pic, other stuff</li>
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
