@extends('layouts.app')

@section('content')
<div id="old-friends" data-type="old">
	<h2>Friends I want to Meet at the Conference</h2>

	<ul data-bind="template: { foreach: items, name: 'person-template' }"></ul>

	<hr>

	<form data-bind="submit: addItem">
		Add friend by twitter handle:<br>
		@<input data-bind='value: itemToAdd, valueUpdate: "afterkeydown"' />
		<button type="submit" data-bind="enable: itemToAdd().length > 0">Add</button>
	</form>
</div>

<div id="new-friends" data-type="new">
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
	<li>
		<span data-bind="text: first_name + ' ' + last_name"></span>
		<a href="#" data-bind="text: '@' + twitter, attr: { href: 'http://twitter.com/' + twitter }"></a>
		<button class="destroy" data-bind="click: $root.remove">x</button>
	</li>
</script>

<br><br><br>
<h2>@todo</h2>
<ul>
	<li><strike>Add user login</strike></li>
	<li><strike>Scope tasks to user</strike></li>
	<li>Allow checking someone off as "met"</li>
	<li>Add first name, last name, profile pic, other stuff</li>
	<li>Make it not hideous</li>
	<li>Add notes for how you met someone</li>
</ul>
@stop
