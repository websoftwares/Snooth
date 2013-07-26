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

    public function __construct(SnoothInterface $client = null, $debug = true)
    {
        if (! $client) {
            throw new SnoothException('A client must be provided');
        }

        $this->client = $client;
        $this->debug = $debug;
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
