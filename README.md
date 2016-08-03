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
{ "canonicalPath" : "/your_username/checkin/checkin_id",
  "canonicalUrl" : "https://foursquare.com/your_username/checkin/checkin_id",
  "comments" : { "count" : 0 },
  "createdAt" : 1464777961,
  "id" : "checkin_id",
  "like" : false,
  "likes" : { "count" : 1,
      "groups" : [ { "count" : 1,
            "items" : [ { "canonicalPath" : "/xxxxxx",
                  "canonicalUrl" : "https://foursquare.com/xxxxxx",
                  "firstName" : "Peter",
                  "gender" : "none",
                  "id" : "xxxxxx",
                  "lastName" : "Beispiel",
                  "photo" : { "prefix" : "https://irs0.4sqi.net/img/user/",
                      "suffix" : "/122782344-IYCANBGWSJ5C0K3T.jpg"
                    },
                  "relationship" : "friend"
                } ],
            "type" : "friends"
          } ],
      "summary" : "Peter Beispiel"
    },
  "photos" : { "count" : 0,
      "items" : [  ]
    },
  "score" : { "total" : 3 },
  "source" : { "name" : "Swarm for iOS",
      "url" : "https://www.swarmapp.com"
    },
  "timeZoneOffset" : 120,
  "type" : "checkin",
  "venue" : { "canonicalPath" : "/v/agentur-zur-%C3%BCberwindung-des-kapitalismus/venue_id",
      "canonicalUrl" : "https://foursquare.com/v/agentur-zur-%C3%BCberwindung-des-kapitalismus/venue_id",
      "categories" : [ { "icon" : { "mapPrefix" : "https://ss3.4sqi.net/img/categories_map/building/default",
                "prefix" : "https://ss3.4sqi.net/img/categories_v2/building/default_",
                "suffix" : ".png"
              },
            "id" : "ididididididididididid",
            "name" : "Non-Profit",
            "pluralName" : "Non-Profits",
            "primary" : true,
            "shortName" : "Non-Profit"
          } ],
      "id" : "venue_id",
      "location" : { "address" : "Straße Str. 85",
          "cc" : "DE",
          "city" : "Berlin",
          "contextLine" : "Kreuzberg",
          "country" : "Germany",
          "lat" : 52.0,
          "lng" : 13.435015500495,
          "neighborhood" : "Kreuzberg",
          "postalCode" : "10997",
          "state" : "Berlin"
        },
      "name" : "Venue Name",
      "stats" : { "checkinsCount" : 134,
          "tipCount" : 1,
          "usersCount" : 9
        },
      "verified" : false
    }
}
```

**Request:** 
`https://api.example.tld/swarm/index.php?fetch=user`

**Returns:** 
```javascript
{ "bio" : "",
  "canonicalPath" : "/your_username",
  "canonicalUrl" : "https://foursquare.com/your_username",
  "capabilities" : { "canAddTips" : true,
      "canHaveFriends" : true,
      "canManageOtherAccounts" : false
    },
  "contact" : { "email" : "your_email.tld",
      "twitter" : "your_twitter_name"
    },
  "firstName" : "First Name",
  "gender" : "none",
  "hasMobileClientConsumer" : true,
  "hasSwarm" : true,
  "homeCity" : "Berlin",
  "id" : "xxxxxxxxx",
  "isAnonymous" : false,
  "isManager" : false,
  "lists" : { "groups" : [ { "count" : 4,
            "items" : [  ],
            "type" : "created"
          } ] },
  "locale" : "en",
  "location" : { "countryCode" : "DE",
      "lat" : 52,
      "lng" : 13,
      "location" : "Berlin"
    },
  "photo" : { "prefix" : "https://irs3.4sqi.net/img/user/",
      "suffix" : "/xxx.jpg"
    },
  "relationship" : "self",
  "roles" : [  ],
  "settings" : { "allowOff4sqAds" : false },
  "tips" : { "count" : 2 }
}
```

### 2. as a library
Just require `functions.php` and use `getData( $arg )`.


| $arg 	 | description 					 |
|----------- |------------------------------ |
| `user`   	 | returns user data 			 |
| `checkins` | returns the last 50 checkins. |


## Background
The foursquare api doesn't allow you to fetch your last checkins or your settings without oAuth or in userless mode. So I scripted this workaround.
