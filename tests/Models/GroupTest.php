<?php
/**
 * Created by IntelliJ IDEA.
 * User: Marc
 * Date: 7/17/2014
 * Time: 7:51 PM
 */

namespace kenobi883\GoToMeeting\Models;


class GroupTest extends \PHPUnit_Framework_TestCase
{
    protected $responseArray;
    
    public function setUp()
    {
        $this->responseArray = array(
            'groupkey' => 300000000000011,
            'parentKey' => 300000000000011,
            'groupName' => 'Something 1, Inc.',
            'status' => 'active',
            'numOrganizers' => 7
        );
    }
    
    public function testParseFromJson()
    {
        $group = new Group();
        $group->parseFromJson($this->responseArray);
        $this->assertThat($group, $this->attributeEqualTo('groupKey', $this->responseArray['groupkey']));
        $this->assertThat($group, $this->attributeEqualTo('parentKey', $this->responseArray['parentKey']));
        $this->assertThat($group, $this->attributeEqualTo('groupName', $this->responseArray['groupName']));
        $this->assertThat($group, $this->attributeEqualTo('status', $this->responseArray['status']));
        $this->assertThat($group, $this->attributeEqualTo('numberOfOrganizers', $this->responseArray['numOrganizers']));
    }

    public function testJsonSerialize()
    {
        $groupObject = new Group($this->responseArray);
        $groupJson = $groupObject->jsonSerialize();
        $this->assertArrayHasKey('groupKey', $groupJson);
        $this->assertArrayHasKey('parentKey', $groupJson);
        $this->assertArrayHasKey('groupName', $groupJson);
        $this->assertArrayHasKey('status', $groupJson);
        $this->assertArrayHasKey('numberOfOrganizers', $groupJson);
    }

    public function testJsonEncode()
    {
        $groupObject = new Group($this->responseArray);
        $groupJson = json_encode($groupObject);
        $this->assertContains('groupName', $groupJson);
        $this->assertContains($groupObject->getGroupName(), $groupJson);
    }
}
 