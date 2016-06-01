# A simple Swarm API written in PHP 🐝
Tired of OAuth and userless access? You just want to read out your last checkins or settings? This API is for you.

It basically logs you in as a desktop user and gives you access to your Swarm data. You can query user settings or the checkin history just by attaching parameters onto `index.php`.

It's a functional script, sorry OOP folks.

## Installation
Fill in your foursquare/swarm credentials in `config.php` and put the files somewhere on your server.

## Usage
### 1. via GET requests
Place the files on your webserver and query `index.php` via GET.

|  parameter 		| choices              		| description	|
|------------------	|--------------------------	| ------------- |
| `$_GET['fetch']` 	| `checkins` or `user` 		| which kind of data do you want to fetch?	|
| `$_GET['count']` 	| Integer between `1` – `49`| how many past checkins? `1` - the last one; `2` - the last two etc.	|

#### Examples
**Request:** 
`https://api.example.tld/swarm/index.php?fetch=checkins&count=1`

**Returns:** 
```javascript
{"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"timeZoneOffset":120,"score":{"total":3},"likes":{"count":1,"groups":[{"type":"friends","count":1,"items":[{"photo":{"prefix":"https:\/\/irs0.4sqi.net\/img\/user\/","suffix":"\/122782344-IYCANBGWSJ5C0K3T.jpg"},"lastName":"Beispiel","firstName":"Peter","relationship":"friend","id":"xxxxxx","canonicalPath":"\/xxxxxx","canonicalUrl":"https:\/\/foursquare.com\/xxxxxx","gender":"none"}]}],"summary":"Peter Beispiel"},"id":"checkin_id","canonicalPath":"\/your_username\/checkin\/checkin_id","canonicalUrl":"https:\/\/foursquare.com\/your_username\/checkin\/checkin_id","createdAt":1464777961,"type":"checkin","like":false,"venue":{"name":"Venue Name","stats":{"checkinsCount":134,"usersCount":9,"tipCount":1},"location":{"city":"Berlin","lng":13.435015500495,"contextLine":"Kreuzberg","state":"Berlin","neighborhood":"Kreuzberg","country":"Germany","postalCode":"10997","address":"Straße Str. 85","cc":"DE","lat":52.00000000000},"id":"venue_id","canonicalPath":"\/v\/agentur-zur-%C3%BCberwindung-des-kapitalismus\/venue_id","canonicalUrl":"https:\/\/foursquare.com\/v\/agentur-zur-%C3%BCberwindung-des-kapitalismus\/venue_id","categories":[{"pluralName":"Non-Profits","name":"Non-Profit","icon":{"prefix":"https:\/\/ss3.4sqi.net\/img\/categories_v2\/building\/default_","mapPrefix":"https:\/\/ss3.4sqi.net\/img\/categories_map\/building\/default","suffix":".png"},"id":"ididididididididididid","shortName":"Non-Profit","primary":true}],"verified":false},"photos":{"count":0,"items":[]},"comments":{"count":0}}
```

**Request:** 
`https://api.example.tld/swarm/index.php?fetch=user`

**Returns:** 
```javascript
{"lists":{"groups":[{"type":"created","count":4,"items":[]}]},"capabilities":{"canHaveFriends":true,"canManageOtherAccounts":false,"canAddTips":true},"location":{"lat":52.000000000000000,"lng":13.000000000000000,"location":"Berlin","countryCode":"DE"},"photo":{"prefix":"https:\/\/irs3.4sqi.net\/img\/user\/","suffix":"\/xxx.jpg"},"contact":{"email":"your_email.tld","twitter":"your_twitter_name"},"hasSwarm":true,"locale":"en","bio":"","firstName":"First Name","relationship":"self","id":"xxxxxxxxx","hasMobileClientConsumer":true,"canonicalPath":"\/your_username","canonicalUrl":"https:\/\/foursquare.com\/your_username","roles":[],"tips":{"count":2},"isAnonymous":false,"isManager":false,"homeCity":"Berlin","settings":{"allowOff4sqAds":false},"gender":"none"}
```

### 2. as a library
Just require `functions.php` and use `getData( $args )`.


| $args 	 | description 					 |
|----------- |------------------------------ |
| `user`   	 | returns user data 			 |
| `checkins` | returns the last 50 checkins. |


## Background
The foursquare api doesn't allow you to fetch your last checkins or your settings without oAuth or in userless mode. So I scripted this workaround.
