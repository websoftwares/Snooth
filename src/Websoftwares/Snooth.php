<?php
namespace Websoftwares;
/**
 * Snooth class
 * PHP client for interacting with the snooth.com RESTful api.
 *
 * @link https://www.api.snooth.com
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
class Snooth
{
    /**
     * $client
     * @var object
     */
    private $client = null;
    /**
     * $debug
     * @var boolean
     */
    private $debug = false;

    public function __construct(SnoothInterface $client = null, $debug = false)
    {
        if (! $client) {
            throw new SnoothException('A client must be provided');
        }

        $this->client = $client;
        $this->debug = $debug;
    }

    /**
     * api returns decoded result object
     *
     * @param  string $method the avin number
     * @return object
     */
    public function api($method = null)
    {
        // See if api method is set
        if (! $method) {
            throw new SnoothException('Please provide a valid Api method');
        }

        // Check if api method is valid
        $validMethods  = array(
            'wines',
            'create-account',
            'rate',
            'wishlist',
            'wine',
            'my-wines',
            'stores',
            'store',
            'winery',
            'action',
            'getTheUnitTestMethod'
            );

        if (! in_array($method, $validMethods)) {
            throw new SnoothException($method . ' is not valid, please provide a valid Api method');
        }

        // Create url for making the request
        $this->client->setUrl($method);

        // For testing
        if ($this->debug) {
            // Returned compiled url
            return $this->client->getUrl();
        }
        // Get response
        return $this->client->execute();
    }

    /**
     * __call overloading client methods
     * @param  string $method
     * @param  mixed  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (! method_exists($this,$method)) {
            call_user_func_array(array($this->client, $method), $args);

            return $this;
        }
    }
}
