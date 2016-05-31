<?php
namespace antonienko\Ph7lconApi\Response;

class HttpCode
{
    private $statusCode;
    private $statusMessage;

    public function __construct(int $statusCode, string $statusMessage)
    {
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
    }

    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function getStatusMessage() : string
    {
        return $this->statusMessage;
    }
}