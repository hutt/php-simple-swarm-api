<?php
require("config.php");

function getData($type = 'checkins'){
	if( isCached() ){ //Cached
		$cacheContents = readCache();
		$return = $cacheContents[1];

	}else{ //NOT Cached
		//Initiate cURL.
		$curl = curl_init();

		// Get the fs-request-signature
		curl_setopt($curl, CURLOPT_URL, LOGIN_FORM_URL);
		 
		//Use the cookie file.
		curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
		 
		//Use the same user agent, just in case it is used by the server for session validation.
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
		 
		//We don't want any HTTPS / SSL errors.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$loginSite = curl_exec($curl);
		//echo $loginSite;
		preg_match('/(?:name\=\"fs-request-signature\"\svalue\=\")([a-z0-9\:]+)(?:\")/', $loginSite, $treffer);

		//Get request signature
		$requestSignature = $treffer[1];

		///////////////////////////////////////////////////////////////

		//An associative array that represents the required form fields.
		//You will need to change the keys / index names to match the name of the form
		//fields.
		$postValues = array(
			'fs-request-signature' => $requestSignature,
		    'emailOrPhone' => USERNAME,
		    'password' => PASSWORD
		);

		//Set the URL that we want to send our POST request to. In this
		//case, it's the action URL of the login form.
		curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
		 
		//Tell cURL that we want to carry out a POST request.
		curl_setopt($curl, CURLOPT_POST, true);
		 
		//Set our post fields / date (from the array above).
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
		 
		//We don't want any HTTPS errors.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		 
		//Where our cookie details are saved. This is typically required
		//for authentication, as the session ID is usually saved in the cookie file.
		curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
		 
		//Sets the user agent. Some websites will attempt to block bot user agents.
		//Hence the reason I gave it a Chrome user agent.
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
		 
		//Tells cURL to return the output once the request has been executed.
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		//Allows us to set the referer header. In this particular case, we are 
		//fooling the server into thinking that we were referred by the login form.
		curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
		 
		//Do we want to follow any redirects?
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		 
		//Execute the login request.
		curl_exec($curl);
		 
		//Check for errors!
		if(curl_errno($curl)){
		    throw new Exception(curl_error($curl));
		}
		 
		//We should be logged in by now. Let's attempt to access a password protected page
		curl_setopt($curl, CURLOPT_URL, 'https://www.swarmapp.com/history');
		 
		//Use the same cookie file.
		curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
		 
		//Use the same user agent, just in case it is used by the server for session validation.
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
		 
		//We don't want any HTTPS / SSL errors.
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		 
		//Execute the GET request and save the result in $history_site
		$history_site = curl_exec($curl);

		//Match Checkin-List from Website
		switch ($type) {
			case 'user':
				preg_match('/(?:historyJson\:.*\,\scurrentUser\:\s)(.*)(?:\,\sisMobile\:)/', $history_site, $treffer);
				break;

			case 'checkins':
				preg_match('/(?:historyJson\:)(.*)(?:\,\scurrentUser\:)/', $history_site, $treffer);
				break;
		}
		
		//save capturing group content
		$return = $treffer[1];
		writeCache($return);
	}

	//return
	return $return;
}

function writeCache($content){

	//prepare file content
	$preparedContent = array();
	$preparedContent[0] = time();
	$preparedContent[1] = $content;

	//Open, write and close file.
	file_put_contents(CACHE_FILE, json_encode($preparedContent));
}

function isCached(){
	$cacheContent = readCache();
	$now = time();
	if(($now - $cacheContent[0]) > TTL){
		//Older than cache TTL seconds
		
		return false;
	}else{

		return true;
	}
}

function readCache(){
	$content = json_decode(file_get_contents(CACHE_FILE));
	return $content;
}

?>
