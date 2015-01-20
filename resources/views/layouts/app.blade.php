@include('layouts.header')

<div class="nav clearfix">
    @if (Auth::check()) {{ Html::linkRoute('conferences.index', 'Conferences') }} |
    {{ Html::linkRoute('account', 'Account') }} |
    {{ Html::linkRoute('logout', 'Logout (' . Auth::user()->email . ')', [], ['class' => 'logout-link']) }}
    @endif
</div>
<br style="clear: both;">


@if (Session::has('flash_notice'))
    <div class="flash_notice">{{ Session::get('flash_notice') }}</div>
@endif
@if ($errors->any())
    <h3>Errors:</h3>
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

@yield('content')

</div>

@include('layouts.footer', ['context' => 'app'])
