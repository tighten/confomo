@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>
        <conference inline-template>
            <a href="/dashboard">&lt;- Back to dashboard</a>

            <friends-list :list="newFriends" key="new-friends" :conference-id="conferenceId" descriptor="New"></friends-list>

            <friends-list :list="onlineFriends" key="online-friends" :conference-id="conferenceId" descriptor="Online"></friends-list>
        </dashboard>
    </div>
@endsection
