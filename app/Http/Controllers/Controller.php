<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Return a file response.
     *
     * @param  string  $path
     * @param  array  $headers
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function fileResponse($path, $headers = [])
    {
        return new BinaryFileResponse($path, 200, $headers);
    }
}
