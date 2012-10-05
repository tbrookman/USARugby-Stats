<?php

namespace Source;

use AllPlayers\AllPlayersClient;
use Guzzle\Service\Inspector;
use Guzzle\Http\Plugin\OauthPlugin;
use Guzzle\Service\Resource\ResourceIteratorClassFactory;

class APSource extends AllPlayersClient {

    public static function factory($config = array()) {
        $attributes = $_SESSION['_sf2_attributes'];
        $default = array(
            'oauth' => array(
                'consumer_key' => $attributes['consumer_key'],
                'consumer_secret' => $attributes['consumer_secret'],
                'token' => $attributes['auth_token'],
                'token_secret' => $attributes['auth_secret']
            ),
            'base_url' => 'https://{host}/api/v1/rest',
            'host' => parse_url($attributes['domain'], PHP_URL_HOST),
            'curl.CURLOPT_SSL_VERIFYPEER' => FALSE, // @todo TRUE
            'curl.CURLOPT_CAINFO' => 'assets/mozilla.pem',
            'curl.CURLOPT_FOLLOWLOCATION' => FALSE,
            'command.prefix' => 'AllPlayers\\Command\\',
        );
        $required = array('base_url');
        $config = Inspector::prepareConfig($config, $default, $required);
        $auth = new OauthPlugin($config->get('oauth'));
        $client = new self($config->get('base_url'), $auth);
        $client->setDefaultHeaders(array('Accept' => 'application/json'));
        $client->resourceIteratorFactory = new ResourceIteratorClassFactory('AllPlayers\\Model');
        $client->setConfig($config);
        return $client;
    }

    public function getGroupMembers($group_uuid) {
        $command = $this->getCommand('GetGroupMembers', array('uuid' => $group_uuid));
        $command->setLimit(0);
        $members = $command->execute();
        return $members;
    }

    public function getUserByUUID($uuid) {
        $command = $this->getCommand('GetUser', array('uuid' => $uuid));
        $user = $command->execute();
        return $user;
    }


    public function getGroupResources($group_uuid, $decode = TRUE) {
       $command = $this->getCommand('GetGroupResources', array('uuid' => $group_uuid));
       $command->execute();
       return empty($decode) ? $command->getResponse()->getBody() : json_decode($command->getResponse()->getBody());
    }

    public function createEvent($event_info) {
        $command = $this->getCommand('create_event', $event_info);
        $event = $command->execute();
        return $event;
    }

    public function updateEvent($uuid, $event_info) {
        $command_params = array_merge(array('uuid' => $uuid), $event_info);
        $command = $this->getCommand('update_event', $command_params);
        $event = $command->execute();
        return $event;
    }

}