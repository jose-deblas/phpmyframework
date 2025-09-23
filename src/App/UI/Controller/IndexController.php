<?php

namespace App\UI\Controller;

use Framework\Http\Request;
use Framework\Http\Response;

class IndexController
{
    public function execute(Request $request): Response
    {
        $body = '<html><body><h1>Home Page from IndexController</h1></body></html>';
        $statusCode = 200;

        return new Response($body, $statusCode);
    }
}
