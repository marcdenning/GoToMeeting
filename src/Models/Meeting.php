<?php
/**
 * Representation of a meeting in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;

/**
 * Class Meeting
 *
 * @package kenobi883\GoToMeeting\Models
 */
class Meeting
{
    /**
     * @var int
     */
    private $uniqueMeetingId;

    /**
     * @var int
     */
    private $meetingId;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var string
     */
    private $conferenceCallInfo;

    /**
     * @var bool
     */
    private $passwordRequired;

    /**
     * @var string
     */
    private $meetingType;

    /**
     * @var int
     */
    private $maxParticipants;

    /**
     * Constructor for a meeting.
     *
     * @param array $response optional response body data to populate model
     */
    public function __construct($response = array())
    {
        $this->parseFromJson($response);
    }

    /**
     * @return string
     */
    public function getConferenceCallInfo()
    {
        return $this->conferenceCallInfo;
    }

    /**
     * @param string $conferenceCallInfo
     */
    public function setConferenceCallInfo($conferenceCallInfo)
    {
        $this->conferenceCallInfo = $conferenceCallInfo;
    }

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param \DateTime $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return int
     */
    public function getMaxParticipants()
    {
        return $this->maxParticipants;
    }

    /**
     * @param int $maxParticipants
     */
    public function setMaxParticipants($maxParticipants)
    {
        $this->maxParticipants = $maxParticipants;
    }

    /**
     * @return int
     */
    public function getMeetingId()
    {
        return $this->meetingId;
    }

    /**
     * @param int $meetingId
     */
    public function setMeetingId($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    /**
     * @return string
     */
    public function getMeetingType()
    {
        return $this->meetingType;
    }

    /**
     * @param string $meetingType
     */
    public function setMeetingType($meetingType)
    {
        $this->meetingType = $meetingType;
    }

    /**
     * @return boolean
     */
    public function getPasswordRequired()
    {
        return $this->passwordRequired;
    }

    /**
     * @param boolean $passwordRequired
     */
    public function setPasswordRequired($passwordRequired)
    {
        $this->passwordRequired = $passwordRequired;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
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
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getUniqueMeetingId()
    {
        return $this->uniqueMeetingId;
    }

    /**
     * @param int $uniqueMeetingId
     */
    public function setUniqueMeetingId($uniqueMeetingId)
    {
        $this->uniqueMeetingId = $uniqueMeetingId;
    }

    /**
     * Parse each known property into the model from an array of values.
     *
     * @param array $response
     */
    public function parseFromJson($response)
    {
        if (isset($response['uniqueMeetingId'])) {
            $this->setUniqueMeetingId((int) $response['uniqueMeetingId']);
        }
        if (isset($response['meetingId'])) {
            $this->setMeetingId((int) $response['meetingId']);
        }
        if (isset($response['createTime'])) {
            $this->setCreateTime(new \DateTime($response['createTime']));
        }
        if (isset($response['status'])) {
            $this->setStatus($response['status']);
        }
        if (isset($response['subject'])) {
            $this->setSubject($response['subject']);
        }
        if (isset($response['startTime'])) {
            $this->setStartTime(new \DateTime($response['startTime']));
        }
        if (isset($response['endTime'])) {
            $this->setEndTime(new \DateTime($response['endTime']));
        }
        if (isset($response['conferenceCallInfo'])) {
            $this->setConferenceCallInfo($response['conferenceCallInfo']);
        }
        if (isset($response['passwordRequired'])) {
            $this->setPasswordRequired($response['passwordRequired'] == 'true');
        }
        if (isset($response['meetingType'])) {
            $this->setMeetingType($response['meetingType']);
        }
        if (isset($response['maxParticipants'])) {
            $this->setMaxParticipants((int) $response['maxParticipants']);
        }
    }
}
