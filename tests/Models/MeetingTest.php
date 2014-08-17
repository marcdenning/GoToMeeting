<?php
/**
 * Unit test class for the Meeting model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class MeetingTest extends \PHPUnit_Framework_TestCase
{
    protected $responseArray;
    
    public function setUp()
    {
        $this->responseArray = array(
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
            'maxParticipants' => 25
        );
    }
    
    public function testParseFromJson()
    {
        $meetingObject = new Meeting();
        $meetingObject->parseFromJson($this->responseArray);
        $this->assertThat($meetingObject, $this->attributeEqualTo('uniqueMeetingId', $this->responseArray['uniqueMeetingId']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingId', $this->responseArray['meetingId']));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'createTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('status', $this->responseArray['status']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('subject', $this->responseArray['subject']));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'startTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'endTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('conferenceCallInfo', $this->responseArray['conferenceCallInfo']));
        $this->assertThat($meetingObject, $this->attribute($this->isFalse(), 'passwordRequired'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingType', $this->responseArray['meetingType']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('maxParticipants', $this->responseArray['maxParticipants']));
    }

    public function testJsonSerialize()
    {
        $meetingObject = new Meeting($this->responseArray);
        $meetingJson = $meetingObject->jsonSerialize();
        $this->assertArrayHasKey('uniqueMeetingId', $meetingJson);
        $this->assertArrayHasKey('meetingId', $meetingJson);
        $this->assertArrayHasKey('createTime', $meetingJson);
        $this->assertArrayHasKey('status', $meetingJson);
        $this->assertArrayHasKey('subject', $meetingJson);
        $this->assertArrayHasKey('startTime', $meetingJson);
        $this->assertArrayHasKey('endTime', $meetingJson);
        $this->assertArrayHasKey('conferenceCallInfo', $meetingJson);
        $this->assertArrayHasKey('passwordRequired', $meetingJson);
        $this->assertArrayHasKey('meetingType', $meetingJson);
        $this->assertArrayHasKey('maxParticipants', $meetingJson);
    }

    public function testJsonEncode()
    {
        $meetingObject = new Meeting($this->responseArray);
        $meetingJson = json_encode($meetingObject);
        $this->assertContains('subject', $meetingJson);
        $this->assertContains($meetingObject->getSubject(), $meetingJson);
    }
}
 