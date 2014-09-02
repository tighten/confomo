<?php

$monolog = Log::getMonolog();
$syslog = new \Monolog\Handler\SyslogHandler('papertrail');
$formatter = new \Monolog\Formatter\LineFormatter('%channel%.CONFOMO.%level_name%: %message% %extra%');
$syslog->setFormatter($formatter);

$monolog->pushHandler($syslog);

foreach (['api', 'user', 'app'] as $route_key)
{
	require_once("routes/$route_key.php");
}
