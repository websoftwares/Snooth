<?php
use Websoftwares\SnoothClient;
/**
 * Class SnoothClientTest
 * Provide a valid api key to test the 'online' tests.
 */
class SnoothClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register for an api-key @link https://api.snooth.com/register/
     */
    CONST VALID_KEY = '';
    CONST TEST_KEY  = '123456789UnitTestKey';

    /**
     * $debug
     * @var boolean
     */
    private $debug = true;

    /**
     * $reflection
     * @var object
     */
    protected $reflection;

    public function setUp()
    {
        if (! self::VALID_KEY) {
            $this->snoothClient = new SnoothClient(self::TEST_KEY);
        } else {
            $this->snoothClient = new SnoothClient(self::VALID_KEY);
            $this->debug = false;
        }
        $this->reflection = new \ReflectionClass($this->snoothClient);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\SnoothClient', $this->snoothClient);
    }

    public function testPropertiesSucceeds()
    {
        $baseUrl = 'https://api.snooth.com/';
        $this->setProperty('baseUrl', $baseUrl);
        $this->assertEquals($baseUrl, $this->getProperty('baseUrl'));

        $curlOptions = array('1','2','3', 'TEST');
        $this->setProperty('curlOptions', $baseUrl);
        $this->assertEquals($baseUrl, $this->getProperty('curlOptions'));

        $url = 'this.is.a.test.to';
        $this->setProperty('url', $url);
        $this->assertEquals($url, $this->getProperty('url'));

        $parameter = array('key', 'value');
        $this->setProperty('parameter', $parameter);
        $this->assertEquals($parameter, $this->getProperty('parameter'));
    }

    public function testSetUrlSucceeds()
    {
        $actual = $this->snoothClient->setUrl('getTheUnitTestMethod', 'ExpectedResult');
        $key = self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY;
        $expected = 'https://api.snooth.com/getTheUnitTestMethod/ExpectedResult/&akey='.$key.'&format=json';
        $this->assertEquals($expected, $this->getProperty('url'));
    }

    public function testGeturlSucceeds()
    {
        $actual = $this->snoothClient->setUrl('getTheUnitTestMethod', 'ExpectedResult');
        $key = self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY;
        $expected = 'http://api.snooth.cc/rest/v1.0/getTheUnitTestMethod/ExpectedResult/&key='.$key.'&format=json';
        $expected = 'https://api.snooth.com/getTheUnitTestMethod/ExpectedResult/&akey='.$key.'&format=json';
        $this->assertEquals($expected, $this->snoothClient->getUrl());
    }

    public function testGetCurlOptionsSucceeds()
    {
        $expected = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FAILONERROR => true,
            CURLOPT_URL => '',
            CURLOPT_USERAGENT => 'Websoftwares snooth PHP api client'
        );
        $method = $this->getMethod('getCurlOptions');
        $actual = $method->invoke($this->snoothClient);
        $this->assertEquals($expected,$actual);
    }

    public function testGetBaseUrlSucceeds()
    {
        $expected = "http://api.snooth.cc/rest";
        $method = $this->getMethod('getBaseUrl');
        $actual = $method->invoke($this->snoothClient);
        $this->assertEquals($expected,$actual);
    }

    public function testBuildQueryStringSucceeds()
    {
        $expected = "foo=bar";
        $method = $this->getMethod('BuildQueryString');
        $actual = $method->invoke($this->snoothClient, array('foo' => 'bar'));
        $this->assertEquals($expected,$actual);
    }

    public function testSetGetClearParameterSucceeds()
    {
        $expected  = array('PHPUnit' => 'Test', 'key' => self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY, 'format' => 'json');
        $cleared = array('key' => self::VALID_KEY ? self::VALID_KEY : self::TEST_KEY, 'format' => 'json');

        $this->snoothClient->setParameter('PHPUnit', 'Test');
        $method = $this->getMethod('getParameter');
        $this->assertEquals($expected,$method->invoke($this->snoothClient));

        $this->snoothClient->clearParameter();
        $this->assertEquals($cleared,$method->invoke($this->snoothClient));
    }

    /**
     * @expectedException Websoftwares\snoothException
     */
    public function testInstantiateAsObjectFails()
    {
        new snoothClient;
    }

    public function getMethod($method)
    {
        $method = $this->reflection->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }

    public function getProperty($property)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($this->snoothClient);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->snoothClient, $value);
    }
}
