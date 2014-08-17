<?php
/**
 * Unit test class for Attendee model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class AttendeeTest extends \PHPUnit_Framework_TestCase
{
    protected $responseArray;
    
    public function setUp()
    {
        $this->responseArray = array(
            'firstName' => 'Deepak',
            'lastName' => 'George',
            'email' => 'deepak@somewhere.com',
            'groupName' => 'Some Group, Inc.'
        );
    }
    
    public function testParseFromJson()
    {
        $attendeeObject = new Attendee();
        $attendeeObject->parseFromJson($this->responseArray);
        $this->assertThat($attendeeObject, $this->attributeEqualTo('firstName', $this->responseArray['firstName']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('lastName', $this->responseArray['lastName']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('email', $this->responseArray['email']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('groupName', $this->responseArray['groupName']));
    }

    public function testJsonSerialize()
    {
        $attendeeObject = new Attendee($this->responseArray);
        $attendeeJson = $attendeeObject->jsonSerialize();
        $this->assertArrayHasKey('firstName', $attendeeJson);
        $this->assertArrayHasKey('lastName', $attendeeJson);
        $this->assertArrayHasKey('email', $attendeeJson);
        $this->assertArrayHasKey('groupName', $attendeeJson);
    }

    public function testJsonEncode()
    {
        $attendeeObject = new Attendee($this->responseArray);
        $attendeeJson = json_encode($attendeeObject);
        $this->assertContains('firstName', $attendeeJson);
        $this->assertContains($attendeeObject->getFirstName(), $attendeeJson);
    }
}
 