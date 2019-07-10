<?php
if ($_SERVER['CONTENT_TYPE'] == 'application/dns-message')
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
