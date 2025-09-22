<?php

use PHPUnit\Framework\TestCase;

class testIndex extends TestCase
{
    public function setUp(): void
    {
        // Set up the folder path for index.php
        chdir(__DIR__ . '/../');
    }

    public function testHelloWorld()
    {
        // Simulate a request without a name parameter
        $_GET['name'] = null;
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        $this->assertEquals('Hello World', $output);
    }

    public function testHelloName()
    {
        // Simulate a request with a name parameter
        $_GET['name'] = 'Alice';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        $this->assertEquals('Hello Alice', $output);
    }

    public function testHelloNameWithSpecialChars()
    {
        // Simulate a request with a name parameter containing special characters
        $_GET['name'] = '<script>alert("XSS")</script>';
        ob_start();
        include 'index.php';
        $output = ob_get_clean();
        $this->assertEquals('Hello &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;', $output);
    }
}
