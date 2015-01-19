<?php namespace Confomo\Infrastructure;

use Exception;
use Illuminate\Contracts\Config\Repository as Configuration;
use Illuminate\Http\Response;
use Illuminate\Foundation\Debug\ExceptionHandler as BaseExceptionHandler;
use Psr\Log\LoggerInterface;

class ExceptionHandler extends BaseExceptionHandler
{
 /**
	* Create a new exception handler instance.
	*
	* @param \Illuminate\Contracts\Config\Repository $config
	* @param \Psr\Log\LoggerInterface $log
	* @return void
	*/
 public function __construct(Configuration $config, LoggerInterface $log)
 {
			 parent::__construct($config, $log);
 }

 /**
	* Render an exception into a response.
	*
	* @param \Illuminate\Http\Request $request
	* @param \Exception $e
	* @return \Symfony\Component\HttpFoundation\Response
	*/
 public function render($request, Exception $e)
 {
			 $whoops = new \Whoops\Run;
			 $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

			 return new Response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());

 }

}