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
        $error_code_string = $this->applicationErrorCodes[$error->code];
        $this->httpCodes = constant('HttpCodes::' . $error_code_string);
    }

    public function response() : JsonResponse
    {
        return JsonResponse::error($this->errorsCollection, HttpCodes::getAverageErrorCode($this->httpCodes));
    }
}