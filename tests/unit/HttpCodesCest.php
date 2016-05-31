<?php
class HttpCodesCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    // tests
    public function getAverageCodeWorks(UnitTester $I)
    {
        $I->expect('A mix of 4xx codes will return a 400 code');
        $I->assertEquals(400, HttpCodes::getAverageErrorCode([401, 403, 404]));

        $I->expect('With all codes equal, return that precise code');
        $I->assertEquals(403, HttpCodes::getAverageErrorCode([403, 403, 403]));
        $I->assertEquals(503, HttpCodes::getAverageErrorCode([503, 503, 503]));

        $I->expect('A mix of 5xx codes will return a 500 code');
        $I->assertEquals(500, HttpCodes::getAverageErrorCode([500, 503]));

        $I->expect('A mix of 4xx and 5xx codes will return a 500 code');
        $I->assertEquals(500, HttpCodes::getAverageErrorCode([401, 503]));
    }
}
