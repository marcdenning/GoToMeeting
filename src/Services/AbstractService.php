<?php
/**
 * Abstract service implementation.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

/**
 * Abstract service implementation. Additional services should extend this class.
 *
 * @package kenobi883\GoToMeeting\Services
 */
class AbstractService
{
    /**
     * @var string root URL for authorizing requests
     */
    protected $endpoint = '';

    /**
     * @var \kenobi883\GoToMeeting\Client
     */
    protected $client;

    /**
     * Default constructor.
     *
     * @param \kenobi883\GoToMeeting\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

}
