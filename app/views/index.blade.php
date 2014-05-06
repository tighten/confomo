<h1>m347</h1>
<h2>Friends</h2>
<ul>
	@foreach ($friends as $friend)
		<li>{{ $friend->first_name }} {{ $friend->last_name }} <a href="http://twitter.com/{{ $friend->twitter }}">{{ '@' . $friend->twitter }}</a></li>
	@endforeach
</ul>
