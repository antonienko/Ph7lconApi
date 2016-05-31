<?php
namespace antonienko\Ph7lconApi\Response;

class ErrorHandler
{
    private $errorsCollection;
    private $httpCodes;

    private $applicationErrorCodes;

    public function __construct(array $applicationErrorCodes)
    {
        $this->applicationErrorCodes = $applicationErrorCodes;
    }

    public function error($code, $title, $details, DeveloperDetails $developerDetails = null)
    {
        $error = new Error($code, $title, $details, $developerDetails);
        $this->add($error);
    }

    private function add(Error $error)
    {
        $this->errorsCollection[] = $error;
        $this->httpCodes = $this->applicationErrorCodes[$error->code];
    }

    public function response() : JsonResponse
    {
        return JsonResponse::error($this->errorsCollection, HttpCodes::getAverageErrorCode($this->httpCodes));
    }
}