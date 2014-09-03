@extends('layouts.app')

@section('content')

<h1 data-conference-id="{{ $conference->id }}">{{ $conference->title }}</h1>

@if ($conference->list_is_public)
	<i>Public:</i> {{ link_to($public_url, $public_url) }}
@else
	<i>Not public</i>
@endif
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
			<a href="#" data-bind="attr: { href: 'http://twitter.com/' + twitter }">
				<img data-bind="attr: { src: twitter_profile_pic }" class="friend-list-item__image">
			</a>
		</div>
		<div class="friend-list-item__body">
			<div>
				<span data-bind="text: first_name + ' ' + last_name"></span>
				<a href="#" data-bind="text: '@' + twitter, attr: { href: 'http://twitter.com/' + twitter }"></a>
			</div><br>
		</div>
		<div class="friend-list-item__actions">
			<a href="#" class="button friend-list-item__action approve-suggested" data-bind="click: approveSuggested">Add Suggested</a>
			<a href="#" class="button friend-list-item__action add-notes" data-bind="click: addNotesPopup">Notes</a>
			<a href="#" class="button friend-list-item__action mark-as-met" data-bind="click: markThisItemMet">Mark met</a>
			<a href="#" class="button friend-list-item__action destroy" data-bind="click: $root.remove">&nbsp;X&nbsp;</a>
		</div>
		<div class="add-notes-popover">
			<form data-bind="submit: addNotes">
				<textarea data-bind="value: notes" rows="4" cols="24"></textarea>
				<div style="float: right">
					<input type="submit"><br><input type="button" value="Cancel" data-bind="click: hideNotesPopup">
				</div>
			</form>
		</div>
	</li>
</script>

@stop
