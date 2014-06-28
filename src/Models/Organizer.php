<?php
/**
 * Representation of an organizer in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;

/**
 * Class Organizer
 * @package kenobi883\GoToMeeting\Models
 */
class Organizer
{
    /**
     * @var string
     */
    private $organizerKey;

    /**
     * @var string
     */
    private $groupKey;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

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
    private $maximumAttendeesAllowed;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getGroupKey()
    {
        return $this->groupKey;
    }

    /**
     * @param string $groupKey
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
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getMaximumAttendeesAllowed()
    {
        return $this->maximumAttendeesAllowed;
    }

    /**
     * @param int $maximumAttendeesAllowed
     */
    public function setMaximumAttendeesAllowed($maximumAttendeesAllowed)
    {
        $this->maximumAttendeesAllowed = $maximumAttendeesAllowed;
    }

    /**
     * @return string
     */
    public function getOrganizerKey()
    {
        return $this->organizerKey;
    }

    /**
     * @param string $organizerKey
     */
    public function setOrganizerKey($organizerKey)
    {
        $this->organizerKey = $organizerKey;
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
}
