<?php

/**
 * Class JwtCest
 * Tests Jwt Token Authentication
 * @see https://tools.ietf.org/html/rfc7519
 */
class JwtCest
{
    private $token;

    /**
     * As a Rest API Client, I want to ensure that I get the correct response when I send incorrect details
     * @param V8restapiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     */
    public function TestScenarioInvalidLogin(V8restapiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $browserDriverHelper->getInstanceURL().'/api/v8/login',
            array(
                'username' => '',
                'password' => ''
            )
        );

        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        // http status code
        $I->assertArrayHasKey('status', $response);
        // sesssion id
        $I->assertArrayHasKey('data', $response);
        // status code as a string
        $I->assertArrayHasKey('message', $response);

        $I->assertEquals('401', $response['status']);
        $I->assertEquals('Unauthorised', $response['message']);
        $I->assertEmpty($response['data']);
    }

    /**
     * As a Rest API Client, I want to login so that I can get a JWT token
     * @param V8restapiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     */
    public function TestScenarioLogin(V8restapiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
       $I->loginAsAdmin();
    }

    /**
     * As a Rest API Client, I want to log so that I can clear my session
     * @param V8restapiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     */
    public function TestScenarioLogout(V8restapiTester $I,  \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->logout();
    }
}
