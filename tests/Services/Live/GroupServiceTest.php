<?php
/**
 * Test class for the GroupService.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;

use kenobi883\GoToMeeting\LiveServiceTestCase;
use kenobi883\GoToMeeting\Services\GroupService;

class GroupServiceTest extends LiveServiceTestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Services\GroupService
     */
    protected $groupService;

    public function __construct()
    {
        $this->liveCredentials = array(
            'apiKey' => '',
            'userId' => '',
            'password' => ''
        );
        parent::__construct();
        if (strlen($this->liveCredentials['apiKey']) > 0) {
            $this->groupService = new GroupService($this->client);
        }
    }

    public function testGetGroups()
    {
        $groups = $this->groupService->getGroups();
        $this->assertNotEmpty($groups);
        $this->assertInstanceOf('Group', $groups[0]);
    }
}
 