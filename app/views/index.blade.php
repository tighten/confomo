@extends('layouts.app')

@section('content')
<div class="friends-list-container old-friends-list-container" id="old-friends" data-type="old">
	<h2>Friends I want to Meet at the Conference</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' />
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<div class="friends-list-container new-friends-list-container" id="new-friends" data-type="new">
	<h2>Friends I Met at the Conference And Want to Remember</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' />
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
	<li>Add first name, last name, profile pic, other stuff</li>
	<li>Add notes for how you met someone</li>
	<li>Make it not hideous</li>
</ul>
@stop
