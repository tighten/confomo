@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>
            <a href="/dashboard">&lt;- Back to dashboard</a>
            <conference></conference>
    </div>
@endsection
