<?php
/**
 * Auth model test class
 * @package \kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class AuthTest extends \PHPUnit_Framework_TestCase
{
    protected $responseArray;
    
    public function setUp()
    {
        $this->responseArray = array(
            'access_token' => '3645136ef45675a113adb18027dd7df8',
            'expires_in' => '30758399',
            'refresh_token' => '1dd48bf4aa453162521250d772a03ae6',
            'organizer_key' => '300000000000384444',
            'account_key' => '300000000000329487',
            'account_type' => 'corporate',
            'firstName' => 'Test',
            'lastName' => 'Test',
            'email' => 'test@test.com'
        );
    }
    
    public function testParseFromJson()
    {
        $authObject = new Auth();
        $authObject->parseFromJson($this->responseArray);
        $this->assertThat($authObject, $this->attributeEqualTo('accessToken', $this->responseArray['access_token']));
        $this->assertThat($authObject, $this->attributeEqualTo('expiresIn', $this->responseArray['expires_in']));
        $this->assertThat($authObject, $this->attributeEqualTo('refreshToken', $this->responseArray['refresh_token']));
        $this->assertThat($authObject, $this->attributeEqualTo('organizerKey', $this->responseArray['organizer_key']));
        $this->assertThat($authObject, $this->attributeEqualTo('accountKey', $this->responseArray['account_key']));
        $this->assertThat($authObject, $this->attributeEqualTo('accountType', $this->responseArray['account_type']));
        $this->assertThat($authObject, $this->attributeEqualTo('firstName', $this->responseArray['firstName']));
        $this->assertThat($authObject, $this->attributeEqualTo('lastName', $this->responseArray['lastName']));
        $this->assertThat($authObject, $this->attributeEqualTo('email', $this->responseArray['email']));
    }

    public function testJsonSerialize()
    {
        $authObject = new Auth($this->responseArray);
        $authJson = $authObject->jsonSerialize();
        $this->assertArrayHasKey('accessToken', $authJson);
        $this->assertArrayHasKey('expiresIn', $authJson);
        $this->assertArrayHasKey('refreshToken', $authJson);
        $this->assertArrayHasKey('organizerKey', $authJson);
        $this->assertArrayHasKey('accountKey', $authJson);
        $this->assertArrayHasKey('accountType', $authJson);
        $this->assertArrayHasKey('firstName', $authJson);
        $this->assertArrayHasKey('lastName', $authJson);
        $this->assertArrayHasKey('email', $authJson);
    }

    public function testJsonEncode()
    {
        $authObject = new Auth($this->responseArray);
        $authJson = json_encode($authObject);
        $this->assertContains('accessToken', $authJson);
        $this->assertContains($authObject->getAccessToken(), $authJson);
    }
}
