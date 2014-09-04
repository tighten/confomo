<?php  namespace Confomo\Providers;

use Illuminate\Support\ServiceProvider;
use Log;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogHandler;

class PapertrailServiceProvider extends ServiceProvider
{
	public function register()
	{
	}

	public function boot()
	{
		$monolog = Log::getMonolog();
		$syslog = new SyslogHandler('papertrail');
		$formatter = new LineFormatter('%channel%.CONFOMO.%level_name%: %message% %extra%');
		$syslog->setFormatter($formatter);

		$monolog->pushHandler($syslog);
	}
}
