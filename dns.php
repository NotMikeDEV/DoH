<?php
if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/dns-message')
{
        $request = file_get_contents("php://input");
        header("Content-Type: application/dns-message");
        $s = fsockopen("udp://127.0.0.1", 53, $errno, $errstr);
        if ($s)
        {
                fwrite($s, $request);
                echo fread($s, 4096);
                fclose($s);
        }
}
else if (isset($_GET['dns']))
{
        $request = base64_decode(str_replace(array('-', '_'), array('+', '/'), $_GET['dns']));
        header("Content-Type: application/dns-message");
        $s = fsockopen("udp://127.0.0.1", 53, $errno, $errstr);
        if ($s)
        {
                fwrite($s, $request);
                echo fread($s, 4096);
                fclose($s);
        }
}
