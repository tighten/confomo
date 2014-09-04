<?php

foreach (['api', 'user', 'app'] as $route_key)
{
	require_once("routes/$route_key.php");
}
