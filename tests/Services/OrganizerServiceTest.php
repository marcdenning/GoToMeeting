<?php
/**
 * Test class for the Organizer service.
 * @package \kenobi883\GoToMeeting\Services
 */
namespace Services;


use kenobi883\GoToMeeting\Models\Organizer;
use kenobi883\GoToMeeting\Services\OrganizerService;

class OrganizerServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOrganizerById()
    {
        $responseArray = array(
            'organizerkey' => 123456,
            'groupkey' => 789,
            'email' => 'test@test.com',
            'firstname' => 'Test',
            'lastname' => 'Test',
            'groupname' => 'testgroup',
            'status' => 'active',
            'maxnumattendeesallowed' => 25
        );
        $expectedOrganizer = new Organizer($responseArray);
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue($responseArray));
        $organizerService = new OrganizerService($client);
        $actualOrganizer = $organizerService->getOrganizerById(1);
        $this->assertNotNull($actualOrganizer);
        $this->assertEquals($expectedOrganizer, $actualOrganizer);
    }

    public function testGetOrganizerByEmail()
    {
        $responseArray = array(
            'organizerkey' => 123456,
            'groupkey' => 789,
            'email' => 'test@test.com',
            'firstname' => 'Test',
            'lastname' => 'Test',
            'groupname' => 'testgroup',
            'status' => 'active',
            'maxnumattendeesallowed' => 25
        );
        $expectedOrganizer = new Organizer($responseArray);
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue($responseArray));
        $organizerService = new OrganizerService($client);
        $actualOrganizer = $organizerService->getOrganizerByEmail('test@test.com');
        $this->assertNotNull($actualOrganizer);
        $this->assertEquals($expectedOrganizer, $actualOrganizer);
    }

    public function testGetOrganizersByGroup()
    {
        $responseArray = array(
            array(
                'organizerkey' => 123456,
                'groupkey' => 789,
                'email' => 'test@test.com',
                'firstname' => 'Test',
                'lastname' => 'Test',
                'groupname' => 'testgroup',
                'status' => 'active',
                'maxnumattendeesallowed' => 25
            )
        );
        $expectedOrganizer = new Organizer($responseArray[0]);
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue($responseArray));
        $organizerService = new OrganizerService($client);
        $organizers = $organizerService->getOrganizersByGroup(789);
        $this->assertNotEmpty($organizers);
        $this->assertNotNull($organizers[0]);
        $this->assertEquals($expectedOrganizer, $organizers[0]);
    }
}
 