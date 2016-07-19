@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>
        <h1>
            {{ $conference->user->name }}

            @if($conference->isUpcoming())
                is going to {{ $conference->name }}. Would you like to meet?
            @elseif($conference->isInProgress())
                is at {{ $conference->name }}. Have you met?
            @elseif($conference->isFinished())
                went to {{ $conference->name }}. Did you meet?
            @endif
        </h1>
        @if (auth()->check())
            <a href="/conferences/{{ $conference->id }}">&lt;- Back to conference dashboard</a>
        @endif

        <br><br>

        <conference-introduction></conference-introduction>
    </div>
@endsection
