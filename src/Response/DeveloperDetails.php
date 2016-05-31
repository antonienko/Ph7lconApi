<?php
namespace antonienko\Ph7lconApi\Response;

class DeveloperDetails
{
    private $details;
    private $file;
    private $line;

    /**
     * DeveloperDetails constructor.
     * @param $details
     * @param $file
     * @param $line
     */
    public function __construct($details, $file, $line)
    {
        $this->details = $details;
        $this->file = $file;
        $this->line = $line;
    }

    public function __toString()
    {
        return sprintf('%s (%s): %s', $this->file, $this->line, $this->details);
    }
}