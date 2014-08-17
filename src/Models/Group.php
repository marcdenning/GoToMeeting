<?php
/**
 * Representation of a group in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class Group implements \JsonSerializable
{
    /**
     * @var int
     */
    private $groupKey;

    /**
     * @var int
     */
    private $parentKey;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $numberOfOrganizers;

    /**
     * @param array $response optional parameter to construct the group from a response object
     */
    function __construct($response = array())
    {
        $this->parseFromJson($response);
    }

    /**
     * @return int
     */
    public function getGroupKey()
    {
        return $this->groupKey;
    }

    /**
     * @param int $groupKey
     */
    public function setGroupKey($groupKey)
    {
        $this->groupKey = $groupKey;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return int
     */
    public function getNumberOfOrganizers()
    {
        return $this->numberOfOrganizers;
    }

    /**
     * @param int $numberOfOrganizers
     */
    public function setNumberOfOrganizers($numberOfOrganizers)
    {
        $this->numberOfOrganizers = $numberOfOrganizers;
    }

    /**
     * @return int
     */
    public function getParentKey()
    {
        return $this->parentKey;
    }

    /**
     * @param int $parentKey
     */
    public function setParentKey($parentKey)
    {
        $this->parentKey = $parentKey;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param array $response JSON-decoded response from a group request
     */
    public function parseFromJson($response)
    {
        if (isset($response['groupkey'])) {
            $this->setGroupKey((int) $response['groupkey']);
        }
        if (isset($response['parentKey'])) {
            $this->setParentKey((int) $response['parentKey']);
        }
        if (isset($response['groupName'])) {
            $this->setGroupName($response['groupName']);
        }
        if (isset($response['status'])) {
            $this->setStatus($response['status']);
        }
        if (isset($response['numOrganizers'])) {
            $this->setNumberOfOrganizers((int) $response['numOrganizers']);
        }
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
