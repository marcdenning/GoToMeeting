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

    /**
     * @dataProvider createOrganizer
     */
    public function testCreateOrganizer($groupKey, Organizer $organizer, $response)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue($response));
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('POST'),
                $this->logicalAnd($this->stringStartsWith('groups'), $this->stringEndsWith('organizers')),
                null,
                false,
                $organizer->toArrayForApi()
            );
        $organizerService = new OrganizerService($client);
        $actualOrganizer = $organizerService->createOrganizer($groupKey, $organizer);
        $this->assertNotNull($actualOrganizer);
        $this->assertAttributeEquals($response, 'organizerKey', $actualOrganizer);
    }

    /**
     * @dataProvider updateOrganizer
     */
    public function testUpdateOrganizerStatus($organizerKey, $isActive)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $requestBody = array(
            'status' => $isActive ? 'active' : 'suspended'
        );
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('PUT'),
                $this->logicalAnd($this->stringStartsWith('organizers'), $this->stringEndsWith($organizerKey)),
                null,
                false,
                $requestBody
            );
        $organizerService = new OrganizerService($client);
        $organizerService->updateOrganizerStatus($organizerKey, $isActive);
    }

    /**
     * @dataProvider updateOrganizer
     */
    public function testDeleteOrganizer($organizerKey)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('DELETE'),
                $this->logicalAnd($this->stringStartsWith('organizers'), $this->stringEndsWith($organizerKey))
            );
        $organizerService = new OrganizerService($client);
        $organizerService->deleteOrganizer($organizerKey);
    }

    /**
     * @dataProvider createOrganizer
     */
    public function testDeleteOrganizerByEmail($groupKey, Organizer $organizer)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('DELETE'),
                $this->stringStartsWith('organizers')
            );
        $organizerService = new OrganizerService($client);
        $organizerService->deleteOrganizerByEmail($organizer->getEmail());
    }

    public function createOrganizer()
    {
        $organizer = new Organizer();
        $response = 66778899;
        $groupKey = 12345;
        $organizer->setEmail('test@example.com');
        $organizer->setFirstName('Jane');
        $organizer->setLastName('Smith');
        $organizer->setProductType('g2m');
        return array(
            array(
                $groupKey,
                $organizer,
                $response
            )
        );
    }

    public function updateOrganizer()
    {
        $organizerKey = 66778899;
        $isActive = false;
        return array(
            array(
                $organizerKey,
                $isActive
            )
        );
    }
}
 