<?php
if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/dns-message')
{
        // Pull request from form data
        $request = file_get_contents("php://input");
}
else if (isset($_GET['dns']))
{
        // Pull base64-encoded request from query
        $request = base64_decode(str_replace(array('-', '_'), array('+', '/'), $_GET['dns']));
}
else
{
        // If neither? Sorry, this is DNS over HTTP Total Landscaping.
        header('HTTP/1.1 404 Not Found');
        die('<h1>404 Not Found</h1>');
}

// If we're still here, process the request!
header("Content-Type: application/dns-message");
$s = fsockopen("udp://127.0.0.1", 53, $errno, $errstr);
if ($s)
{
        fwrite($s, $request);
        echo fread($s, 4096);
        fclose($s);
}
