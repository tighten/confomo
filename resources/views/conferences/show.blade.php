@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceSlug = "{{ $conference->slug }}";
        </script>

        <h1>{{ $conference->name }}</h1>
        @if ($conference->conf_url)
            <h4><a href="{{ $conference->conf_url }}" target="_blank">{{ $conference->conf_url }}</a></h4>
        @endif
        @if ($conference->start_date && $conference->end_date)
            <div style="text-align: center">{{ $conference->start_date->format('M j, Y') }} - {{ $conference->end_date->format('M j, Y') }}</div>
        @endif

        <a href="/dashboard">&lt;- Back to dashboard</a>

        @if (auth()->user()->owns($conference))
            <span class="pull-right">
                <a class="twitter-share-button"
                href="https://twitter.com/share"
                data-url="{{ url('conferences/' . $conference->slug . '/introduce') }}"
                data-hashtags="ConFOMO"
                data-text="{{ $conference->tweet_text }}"
                >
                    Tweet
                </a>
            </span>
               
            <a href="{{ url('conferences/' . $conference->slug . '/introduce') }}" title="Your public introduction URL" style="float: right; margin-right: 5px;">
                Public Introduction URL
            </a>
        @endif

        <conference></conference>
    </div>
@endsection
