@extends('layouts.app')

@section('content')

{{ Form::open() }}
Conference Name: {{ Form::text('name') }}<br>
Make Conference List Public? Yes {{ Form::radio('list_is_public', 1) }} No {{ Form::radio('list_is_public', 0) }}<br>
{{ Form::submit() }}
{{ Form::close() }}
@stop
