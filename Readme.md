## USA Rugby Statistics system

This system, originally developed by Matt Trenary, provides an interface and tracking for USA Rugbys National Championship Series.
"The National Championship Series web application is designed to facilitate the management of championship event rosters, scores, and game information. It is designed to work from any phone, computer, or tablet that can access the internet."


### Database

To configure the database create file `app/config.php` with the following structure:

```PHP
<?php

$config = array(
  'username' => 'user',
  'password' => 'pass',
  'database' => 'db',
  'server'   => '127.0.0.1',
  'consumer_key'    => 'DEADBEEF',
  'consumer_secret' => 'BEEFDEAD',
  'auth_domain'     => 'https://www.allplayers.com', // Optional
  'admin_group_uuid' => 'ffc1b780-cc4c-11e1-9e39-12313d2a2278',
);
```

Included under directory: "db" is the DDL used for the system; if there are updates to the structure this can be documented using the following command:

`mysqldump -d --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --skip-comments --compact -u<user> -p<pass> <dbname>`


### Composer

Note this project uses [composer](http://getcomposer.org/) to manage dependencies.

Quick start:

```
git clone ...
composer.phar install
```

### OAuth

Generate a token for this app: http://develop.allplayers.com/oauth.html

### Attribution

*  [Matt Trenary](https://github.com/matttrenary)
*  https://github.com/christianchristensen/AllPlayers-OAuth


### Iframe Usage

Currently games support iframeable elements.
There are several parameters you can pass in the [GET] request to `/game.php` in order to properly retrieve iframes.

*  `?iframe=TRUE`
	*  Must be passed for all iframe requests
*  `?id=`
	*  This can either be a uuid of a game or an id.
*  `?uuid=`
	*  Either the `id` or `uuid` may be included in the request, but the `id` take priority.
*  `?ops=`
	*  An array of parts of the page you want to receive in the iframe.
	*  Possible options:
		*  `game_info`
		*  `game_score`
		*  `game_rosters`
		*  `game_score_events`
		*  `game_sub_events`
		*  `game_card_events`


###### Examples
*  `https://usarugbystats.pdup.allplayers.com/game.php?id=123&iframe=TRUE&ops[0]=game_info`
*  `https://usarugbystats.pdup.allplayers.com/game.php?id=123&iframe=TRUE&ops[0]=game_info&ops[1]=game_rosters&ops[2]=game_sub_events`
