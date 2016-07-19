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
