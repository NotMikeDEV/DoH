# DoH

A simple PHP script that can be used to add a Firefox-compatible DoH endpoint to a HTTPS server.

I went looking for a simple CGI/PHP script that I could use to add DoH to an existing web server, but all I could find were complicated server applications and things that required installing a bunch of dependencies and compiling and running them before configuring your web server to proxy to the DoH daemon etc.

I had a look at the protocol itself. Firefox uses the application/dns-message content type. This is literally a DNS request in the same format you would send it over UDP... so, I created a PHP script that does just that! It works, gives me DoH support in Firefox which also allows me to use EncryptedSNI without needing to use a public resolver (my main objective for wanting DoH support on my own resolver).

This is not a full DoH server, it doesn't even pretend to me. Seriously, look at the script. But, it is really easy to install on an existing web server with PHP support and works well enough for Firefox.

I have hard-coded 127.0.0.1 as the address of the upstream recursive DNS resolver. Change it in the script if you must, but I suspect most people will be putting the web server on the same machine as their resolver so it will work "out of the box" for this typical configuration.
