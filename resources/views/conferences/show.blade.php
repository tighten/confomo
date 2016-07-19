@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>

        <h1>{{ $conference->name }}</h1>
        @if ($conference->start_date && $conference->end_date)
            <div style="text-align: center">{{ $conference->start_date->format('M j, Y') }} - {{ $conference->end_date->format('M j, Y') }}</div>
        @endif

        <a href="/dashboard">&lt;- Back to dashboard</a>

        @if (auth()->user()->owns($conference))
            <a href="{{ url('conferences/' . $conference->id . '/introduce') }}" title="Your public introduction URL" style="float: right">
                Public Introduction URL
            </a>
        @endif

        <conference></conference>
    </div>
@endsection
