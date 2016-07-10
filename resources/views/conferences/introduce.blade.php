@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container">
        <h1>
            @if($conference->isUpcoming())
                I'm going to be at {{ $conference->name }}. Would you like to meet?
            @elseif($conference->isInProgress())
                I'm at {{ $conference->name }}. Have we met?
            @elseif($conference->isFinished())
                I went to {{ $conference->name }}. Did we meet?
            @endif
        </h1>
    </div>
@endsection
