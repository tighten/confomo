@extends('layouts.app')

@section('content')

<ul>
@foreach ($conferences as $conference)
	<li>{{ link_to('conferences/' . $conference->id, $conference->name) }}</li>
@endforeach
@if ($conferences->isEmpty())
	<li>No conferences added yet</li>
@endif
</ul>
<br>
{{ HTML::linkAction('conferences.create', 'Add conference') }}

@stop
