<?php

// Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

use Framework\Kernel;
use Framework\Http\Request;

$request = Request::createFromGlobals();

$kernel = new Kernel();
$response = $kernel->handle($request);

$response->send();

//prettyVarDump($_SERVER);
prettyVarDump($_GET);

function prettyVarDump($data) {
    echo '<pre style="
        background: #f4f4f4;
        border: 1px solid #ddd;
        border-left: 3px solid #f36d33;
        color: #666;
        page-break-inside: avoid;
        font-family: monospace;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 1.6em;
        max-width: 100%;
        overflow: auto;
        padding: 1em 1.5em;
        display: block;
        word-wrap: break-word;
    ">';
    var_dump($data);
    echo '</pre>';
}
