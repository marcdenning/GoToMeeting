<?php
/**
 * Unit test class for Organizer model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class OrganizerTest extends \PHPUnit_Framework_TestCase
{
    protected $responseArray;
    
    public function setUp()
    {
        $this->responseArray = array(
            'organizerkey' => 123456,
            'groupkey' => 789,
            'email' => 'test@test.com',
            'firstname' => 'Test',
            'lastname' => 'Test',
            'groupname' => 'testgroup',
            'status' => 'active',
            'maxnumattendeesallowed' => 25
        );
    }
    
    public function testParseFromJson()
    {
        $organizerObject = new Organizer();
        $organizerObject->parseFromJson($this->responseArray);
        $this->assertThat($organizerObject, $this->attributeEqualTo('organizerKey', $this->responseArray['organizerkey']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('groupKey', $this->responseArray['groupkey']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('email', $this->responseArray['email']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('firstName', $this->responseArray['firstname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('lastName', $this->responseArray['lastname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('groupName', $this->responseArray['groupname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('status', $this->responseArray['status']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('maximumAttendeesAllowed', $this->responseArray['maxnumattendeesallowed']));
    }

    public function testJsonSerailize()
    {
        $organizerObject = new Organizer($this->responseArray);
        $organizerJson = $organizerObject->jsonSerialize();
        $this->assertArrayHasKey('organizerKey', $organizerJson);
        $this->assertArrayHasKey('groupKey', $organizerJson);
        $this->assertArrayHasKey('email', $organizerJson);
        $this->assertArrayHasKey('firstName', $organizerJson);
        $this->assertArrayHasKey('lastName', $organizerJson);
        $this->assertArrayHasKey('groupName', $organizerJson);
        $this->assertArrayHasKey('status', $organizerJson);
        $this->assertArrayHasKey('maximumAttendeesAllowed', $organizerJson);
    }

    public function testJsonEncode()
    {
        $organizerObject = new Organizer($this->responseArray);
        $organizerJson = json_encode($organizerObject);
        $this->assertContains('organizerKey', $organizerJson);
        $this->assertContains($organizerObject->getOrganizerKey(), $organizerJson);
    }
}
