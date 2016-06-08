<?php
//your foursquare/swarm email address or phone number
define('USERNAME', '');
 
//your foursquare/swarm account password
define('PASSWORD', '');
 
//of course we're using Chrome ;) (spoof user agent)
define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
 
//store cookies in ./cookie.txt
define('COOKIE_FILE', 'cookie.txt');
 
//url of Swarm login form
define('LOGIN_FORM_URL', 'https://www.swarmapp.com/login');
 
//Swarm login action url
define('LOGIN_ACTION_URL', 'https://www.swarmapp.com/login');

//Cache filename
define('CACHE_FILE', 'cache.txt');

//timespan swarm shall be cached
define('TTL', 1800);

?>