@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.twitter_nickname = "{{ $user->twitter_nickname }}";
        </script>

        <user></user>
    </div>
@endsection
