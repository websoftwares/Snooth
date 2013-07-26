<?php
namespace Websoftwares;
/**
 * SnoothInterface class
 * PHP client for interacting with the snooth.com RESTful api.
 *
 * @link https://www.api.snooth.com
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
interface SnoothInterface
{
    /**
     * setParameter
     * for a complete list of available parameters:
     * @link https://api.snooth.com/
     *
     * @param $key the filter name
     * @param $value the filter value
     */
    public function setParameter($key = null, $value = null);

    /**
     * clearParameter empties/resets filters
     */
    public function clearParameter();

    /**
     * setUrl
     */
    public function setUrl($method);

    /**
     * getUrl returns url
     */
    public function getUrl();

    /**
     * execute requests data
     */
    public function execute();
}
