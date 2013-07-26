<?php
use Websoftwares\SnoothClient, Websoftwares\Snooth, Websoftwares\SnoothException;
/**
 * Class SnoothTest
 * Provide a valid api key to test the 'online' tests.
 */
class SnoothTest extends \PHPUnit_Framework_TestCase
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
    protected $reflection = null;

    public function setUp()
    {
        if (! self::VALID_KEY) {
            $this->snooth = new Snooth(new SnoothClient(self::TEST_KEY), $this->debug);
        } else {
            $this->snooth = new Snooth(new SnoothClient(self::VALID_KEY));
            $this->debug = false;
        }
        $this->reflection = new \ReflectionClass($this->snooth);
    }

    public function testInstantiateAsObjectSucceeds()
    {
        $this->assertInstanceOf('Websoftwares\Snooth', $this->snooth);
    }

    public function testClientPropertySucceeds()
    {
        $client = new \stdClass;
        $this->setProperty('client', $client);
        $this->assertEquals($client, $this->getProperty('client'));
    }

    public function testApiMethodSucceeds()
    {
        if ($this->debug) {
            $actual = $this->snooth->api('wines');
            $expected = 'https://api.snooth.com/wines/?akey=123456789UnitTestKey&format=json';
            $this->assertEquals($expected,$actual);

            $parameters = $this->snooth
                ->setParameter('q', 'Riesling')
                ->setParameter('f', 1)
                ->setParameter('n', 100)
                ->setParameter('a', 0)
                ->setParameter('t', 'wine')
                ->setParameter('color', 'white')
                ->setParameter('m', 7777777)
                ->setParameter('c', 'Germany')
                ->setParameter('z', '12000')
                ->setParameter('lat', 50.901737)
                ->setParameter('lng', 10.986595)
                ->setParameter('s','price+desc')
                ->setParameter('mp', 10.99)
                ->setParameter('mx', 99.00)
                ->setParameter('mr', 0)
                ->setParameter('xr', 3)
                ->setParameter('lang', 'de')
                ->api('wines');

            $this->assertEquals($expected . '&q=Riesling&f=1&n=100&a=0&t=wine&color=white&m=7777777&c=Germany&z=12000&lat=50.901737&lng=10.986595&s=price%2Bdesc&mp=10.99&mx=99&mr=0&xr=3&lang=de', $parameters);

            $reset = $this->snooth->clearParameter()->api('wines');
            $this->assertEquals($expected, $reset);

        } else {
            $expected = 'stdClass';
            $actual = $this->snooth->api('wines');
            $this->assertObjectHasAttribute('wines', $actual);
            $this->assertInstanceOf($expected, $actual);
        }
    }

    public function testclientMethodOverloadingSucceeds()
    {
        $expected = array('lorem', 'ipsum');
        $actual = $this->snooth->__call('setParameter', array('lorem', 'ipsum'));
        $client = $this->getProperty('client');

        $property = new \ReflectionClass($client);
        $property = $property->getProperty('parameter');
        $property->setAccessible(true);
        $actual = $property->getValue($client);

        $this->assertEquals($expected[1], $actual['lorem']);
    }

    /**
     * @expectedException Websoftwares\SnoothException
     */
    public function testApiFails()
    {
        $this->snooth->api();
    }

    /**
     * @expectedException Websoftwares\SnoothException
     */
    public function testApiMethodFails()
    {
        $this->snooth->api('invalidMethod');
    }

    /**
     * @expectedException Websoftwares\SnoothException
     */
    public function testInstantiateAsObjectFails()
    {
        new Snooth;
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

        return $property->getValue($this->snooth);
    }

    public function setProperty($property, $value)
    {
        $property = $this->reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->setValue($this->snooth, $value);
    }
}
