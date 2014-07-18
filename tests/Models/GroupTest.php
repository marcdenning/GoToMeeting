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

    public function testParseFromJson()
    {
        $responseArray = array(
            'groupkey' => 300000000000011,
            'parentKey' => 300000000000011,
            'groupName' => 'Something 1, Inc.',
            'status' => 'active',
            'numOrganizers' => 7
        );
        $group = new Group();
        $group->parseFromJson($responseArray);
        $this->assertThat($group, $this->attributeEqualTo('groupKey', $responseArray['groupkey']));
        $this->assertThat($group, $this->attributeEqualTo('parentKey', $responseArray['parentKey']));
        $this->assertThat($group, $this->attributeEqualTo('groupName', $responseArray['groupName']));
        $this->assertThat($group, $this->attributeEqualTo('status', $responseArray['status']));
        $this->assertThat($group, $this->attributeEqualTo('numberOfOrganizers', $responseArray['numOrganizers']));
    }
}
 