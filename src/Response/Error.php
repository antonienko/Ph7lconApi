<?php
namespace antonienko\Ph7lconApi\Response;

class Error
{
    public $code;
    public $title;
    public $details;
    public $developerDetails;

    public function __construct($code, $title, $details, DeveloperDetails $developerDetails = null)
    {
        $this->code = $code;
        $this->title = $title;
        $this->details = $details;
        $this->developerDetails = (string)$developerDetails;
    }
}