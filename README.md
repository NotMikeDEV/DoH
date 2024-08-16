# DoH

A simple PHP script that can be used to add a DoH endpoint to a HTTPS server.

I went looking for a simple CGI/PHP script that I could use to add DoH to an existing web server, but all I could find were complicated server applications and things that required installing a bunch of dependencies and compiling and running them before configuring your web server to proxy to the DoH daemon etc.

I had a look at the protocol itself. Firefox uses the application/dns-message content type as per RFC8484. This is literally a DNS request in the same format you would send it over UDP... so, I created a PHP script that does just that! It works, gives me DoH support in Firefox which also allows me to use EncryptedSNI without needing to use a public resolver (my main objective for wanting DoH support on my own resolver).

This is not a "full DoH server", it doesn't even pretend to me. Seriously, look at the script. But, it is really easy to install on an existing web server with PHP support and works well enough for Firefox. It fully supports RFC8484 which is the standard for DoH, although it does not do any of the other non-standard forms of DoH that were used prior to RFC8484.

I have hard-coded 127.0.0.1 as the address of the upstream recursive DNS resolver. Change it in the script if you must, but I suspect most people will be putting the web server on the same machine as their resolver so it will work "out of the box" for this typical configuration.

I mostly posted this because I was shocked that every suggestion I came across for running my own DoH server required piles of software and dependencies just to do something so simple.

This readme file is longer than the script. It's almost as if I was trying to make a point...

## How to use

Put the dns.php file on a HTTPS enabled web server that supports PHP and has a local recursive resolver.

If you need to use a separate DNS resolver rather than one on localhost, edit the script accordingly.

That is it.

## What does ChatGPT think?

This PHP code checks if the content type of the HTTP request is "application/dns-message" or if the 'dns' parameter is present in the URL. If either of these conditions are met, it sends a DNS request to a DNS server listening on UDP port 53 at the IP address 127.0.0.1 (localhost), using the content of the request or the base64-decoded value of the 'dns' parameter as the DNS query. The response from the DNS server is then sent back to the client as the response of the HTTP request.

If the content type is "application/dns-message", it reads the content of the request using file_get_contents("php://input"). If the 'dns' parameter is present in the URL, it decodes the base64-encoded value using base64_decode(). In both cases, it then opens a connection to the DNS server using fsockopen() and sends the request using fwrite(). The response is read using fread() and then sent back to the client using echo.

Note that this code assumes that a DNS server is running on the same machine as the PHP script, listening on UDP port 53 at 127.0.0.1. Also, note that this code should only be used for testing or debugging purposes and should not be deployed in a production environment without proper security measures.
