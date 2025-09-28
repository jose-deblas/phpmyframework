<?php

namespace App\UI\Controller;

use Framework\Http\Request;
use Framework\Http\Response;

class PostController extends BaseController
{
    public function execute(Request $request): Response
    {
        prettyVarDump($request);
        $body = '<html><body><h1>PostController Page</h1></body></html>';
        $statusCode = 200;

        return new Response($body, $statusCode);
    }
}
