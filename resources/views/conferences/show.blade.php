@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>
            <h1>{{ $conference->name }}</h1>

            <a href="/dashboard">&lt;- Back to dashboard</a>

            @if (auth()->user()->owns($conference))
                /
                <a href="{{ $conference->introduction_url }}" target="_blank" title="Your public introduction URL">
                    Public Introduction URL
                </a>
            @endif

            <conference></conference>
    </div>
@endsection
