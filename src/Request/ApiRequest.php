<?php
namespace antonienko\Ph7lconApi\Request;

use Phalcon\Http\Request;

class ApiRequest extends Request
{
    public static $responseFormats = ['json'];

    public function getToken() : string
    {
        if ($this->has('token')) {
            return $this->get('token');
        }

        if ($authorization = $this->getHeader('AUTHORIZATION')) {
            return $authorization;
        }
        return '';
    }

    public function isSearch() : bool
    {
        return $this->hasQuery('q');
    }

    public function getSearchQuery() : string
    {
        if (!$this->isSearch()) {
            throw new \LogicException('The request didn\'t include any search');
        }

        return $this->getQuery('q');
    }
}