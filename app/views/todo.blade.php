@extends('layouts.app')

@section('content')

<h1>Todo</h1>
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
	<li><strike>Add notes for how you met someone</strike></li>
	<li>Make it not hideous</li>
	<li>Add loading graphics</li>
	<li><strike>Force twitter handle to be proper twitter handle</strike></li>
	<li><strike>Auto-fill details based on twitter handle</strike></li>
	<li><strike>Make lists public (but notes private?)</strike></li>
	<li>Some other form of community participation</li>
	<li>CHORES</li>
	<li>Consolidate error handling in user create</li>
	<li><strike>Drop Authority because we're clearly not using it</strike></li>
	<li><strike>Allow for multiple conferences</strike></li>
	<li><strike>Allow users to set their own usernames</strike></li>
	<li><strike>Allow users to toggle which conference lists are public</strike></li>
	<li><strike>Allow users to edit conference name and is-public status after creation</strike></li>
	<li>move monolog binding to a service provider</li>
	<li>Extract all Closure routes to controllers</li>
	<li>Convert the whole thing to Angular for easier Ionic-ization</li>
	<li>Get the friggin façades out of the domain already</li>
</ul>

@stop
