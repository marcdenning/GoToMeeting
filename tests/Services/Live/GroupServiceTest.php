<?php
/**
 * Test class for the GroupService.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;

use kenobi883\GoToMeeting\Services\GroupService;

require_once(__DIR__ . '/../../LiveServiceTestCase.php');

class GroupServiceTest extends \kenobi883\GoToMeeting\LiveServiceTestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Services\GroupService
     */
    protected $groupService;

    public function __construct()
    {
        parent::__construct();
        $liveCredentials = array(
            'apiKey' => '',
            'userId' => '',
            'password' => ''
        );
        if (strlen($liveCredentials['apiKey']) > 0) {
            $this->client = $this->configureLiveClient($liveCredentials);
            $this->groupService = new GroupService($this->client);
        }
    }

    public function testGetGroups()
    {
        $groups = $this->groupService->getGroups();
        $this->assertNotEmpty($groups);
        $this->assertInstanceOf('Group', $groups[0]);
    }

    /**
     * @dataProvider groupKey
     */
    public function testGetScheduledMeetings($groupKey)
    {
        $meetings = $this->groupService->getMeetingsByGroup($groupKey);
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertAttributeNotEmpty('groupName', $actualMeeting);
    }

    public function groupKey()
    {
        return array(
            array('input id here')
        );
    }
}
 