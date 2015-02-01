<?php
/**
 * Test class for the GroupService.
 * @package \kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use kenobi883\GoToMeeting\Models\Group;
use kenobi883\GoToMeeting\Models\Meeting;
use kenobi883\GoToMeeting\Models\Organizer;

class GroupServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetGroups()
    {
        $responseArray = array(
            'groupkey' => 300000000000011,
            'parentKey' => 300000000000011,
            'groupName' => 'Something 1, Inc.',
            'status' => 'active',
            'numOrganizers' => 7
        );
        $expectedGroup = new Group($responseArray);
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                $responseArray
            )));
        $groupService = new GroupService($client);
        $actualGroups = $groupService->getGroups();
        $this->assertNotEmpty($actualGroups);
        $this->assertNotNull($actualGroups[0]);
        $this->assertEquals($actualGroups[0], $expectedGroup);
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
        $groupService = new GroupService($client);
        $organizers = $groupService->getOrganizersByGroup(789);
        $this->assertNotEmpty($organizers);
        $this->assertNotNull($organizers[0]);
        $this->assertEquals($expectedOrganizer, $organizers[0]);
    }

    /**
     * @dataProvider singleMeetingProvider
     */
    public function testGetScheduledMeetings($responseArray, $expectedMeeting)
    {
        $groupKey = 12345;
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                $responseArray
            )));
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->stringContains('GET', false),
                $this->stringContains("groups/{$groupKey}/meetings"),
                $this->attributeEqualTo('data', array(
                    'scheduled' => 'true'
                )));
        $groupService = new GroupService($client);
        $meetings = $groupService->getMeetingsByGroup($groupKey);
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertEquals($expectedMeeting, $actualMeeting);
        $this->assertAttributeNotEmpty('groupName', $actualMeeting);
    }

    public function singleMeetingProvider()
    {
        $responseArray = array(
            'uniqueMeetingId' => 1230000000456789,
            'meetingId' => 123456789,
            'createTime' => '2012-06-25T22:10:46.+0000',
            'status' => 'INACTIVE',
            'subject' => 'test',
            'startTime' => '2012-12-01T09:00:00.+0000',
            'endTime' => '2012-12-01T10:00:00.+0000',
            'conferenceCallInfo' => 'Australia: +61 2 9037 1944\nCanada: +1 (647) 977-5956\nUnited Kingdom: +44 (0) 207 151 1850\nIreland: +353 (0) 15 290 180\nUnited States: +1 (773) 945-1031\nAccess Code: 111-952-374',
            'passwordRequired' => 'false',
            'meetingType' => 'scheduled',
            'maxParticipants' => 25,
            'groupName' => 'Developers'
        );
        $expectedMeeting = new Meeting($responseArray);
        return array(
            array(
                $responseArray,
                $expectedMeeting
            )
        );
    }
}
 