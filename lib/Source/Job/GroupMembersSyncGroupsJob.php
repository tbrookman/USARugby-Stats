<?php

namespace Source\Job;

use Kue\Job;
use Source\APSource;
use Source\DataSource;
use Source\QueueHelper;

class GroupMembersSyncGroupsJob implements Job
{
    private $sessionattributes;

    public function __construct($sessionattributes) {
        $this->sessionattributes = $sessionattributes;
    }

    public function run()
    {
        $teams = array();
        $db = new DataSource();
        $teams = $db->getAllTeams();
        $client = APSource::SourceFactory($this->sessionattributes);
        $qh = new QueueHelper();

        foreach ($teams as $uuid => $team) {
            $qh->GroupMembersSync($uuid, $this->sessionattributes);
        }
    }
}