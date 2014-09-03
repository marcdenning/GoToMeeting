<?php
/**
 * Live test class for organizer service.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;


use kenobi883\GoToMeeting\Services\OrganizerService;

require_once(__DIR__ . '/../../LiveServiceTestCase.php');

class OrganizerServiceTest extends \kenobi883\GoToMeeting\LiveServiceTestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Services\OrganizerService
     */
    protected $organizerService;

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
            $this->organizerService = new OrganizerService($this->client);
        }
    }

    public function testGetOrganizerById()
    {
        $organizerId = 0;
        $organizer = $this->organizerService->getOrganizerById($organizerId);
        $actualOrganizerKey = $organizer->getOrganizerKey();
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Organizer', $organizer);
        $this->assertEquals($organizerId, $actualOrganizerKey);
    }

    public function testGetOrganizerByEmail()
    {
        $organizerEmail = 'test@test.com';
        $organizer = $this->organizerService->getOrganizerByEmail($organizerEmail);
        $actualOrganizerEmail = $organizer->getEmail();
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Organizer', $organizer);
        $this->assertEquals($organizerEmail, $actualOrganizerEmail);
    }

    public function testGetOrganizersByGroup()
    {
        $groupKey = 789;
        $numberOfOrganizers = 1;
        $organizers = $this->organizerService->getOrganizersByGroup($groupKey);
        $actualOrganizerGroupKey = $organizers[0]->getGroupKey();
        $this->assertCount($numberOfOrganizers, $organizers);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Organizer', $organizers[0]);
        $this->assertEquals($groupKey, $actualOrganizerGroupKey);
    }
}
 