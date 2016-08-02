<?php
/**
 * @zonda
 * https://github.com/igorw/retry/blob/master/src/retry.php
 */
function retry($retries, $fn)
{
    beginning:
    try {
        return $fn();
    } catch (Exception $e) {
        if (!$retries) {
            throw $e;
        }
        $retries--;
        goto beginning;
    }
}

if (! function_exists('dayBefore')) {
    function dayBefore($dateString)
    {
        return with(new \Carbon\Carbon($dateString))->subDay()->format("Y-m-d");
    }
}

if (! function_exists('abort_if')) {
    /**
     * Throw an HttpException with the given data if the given condition is true.
     *
     * @param  bool    $boolean
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function abort_if($boolean, $code, $message = '', array $headers = [])
    {
        if ($boolean) {
            abort($code, $message, $headers);
        }
    }
}

if (! function_exists('abort_unless')) {
    /**
     * Throw an HttpException with the given data unless the given condition is true.
     *
     * @param  bool    $boolean
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function abort_unless($boolean, $code, $message = '', array $headers = [])
    {
        if (! $boolean) {
            abort($code, $message, $headers);
        }
    }
}
