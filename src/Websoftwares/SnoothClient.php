<?php
namespace Websoftwares;
/**
 * SnoothClient class
 * PHP client for interacting with the snooth.com RESTful api.
 *
 * @link https://www.api.snooth.com
 *
 * @package Websoftwares
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 * @version 0.1
 * @author Boris <boris@websoftwar.es>
 */
class SnoothClient implements SnoothInterface
{
	/**
     * @var string
     */
    protected $baseUrl = "https://api.snooth.com/";

    /**
     * @var array
     */
    protected $curlOptions = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR => true,
        CURLOPT_URL => '',
        CURLOPT_USERAGENT => 'Websoftwares Snooth PHP api client'
        );

    /**
     * @var string
     */
    protected $url = null;

    /**
     * @var array
     */
    protected $parameter = array();

    /**
     * __construct
     * @param string $apiKey
     */
    public function __construct($apiKey = null)
    {
        if (! $apiKey) {
            throw new SnoothException('An apiKey must be provided');
        }
        // Set API key
        $this->setParameter('akey', $apiKey);
        // Only interacting with the JSON Api
        $this->setParameter('format', 'json');
    }

    /**
     * curlOptions
     *
     * @return array
     */
    protected function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
     * curlOptions
     *
     * @param string $option
     * @param string $value
     * @return self
     */
    public function setCurlOptions($option = null, $value = null)
    {
        $this->curlOptions[$option] = $value;
        return $this;
    }

    /**
     * setUrl
     * @return string
     */
    public function setUrl($method)
    {
        // Create url
        $this->url = $this->getBaseUrl() . $method . '/?' . $this->buildQueryString($this->getParameter());
        return $this;
    }

    /**
     * getUrl
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * getParameter
     *
     * @return array
     */
    protected function getParameter()
    {
        return $this->parameter;
    }

    /**
     * setParameter
     * for a complete list of available parameters:
     * @link https://api.snooth.com/
     *
     * @param $key the parameter name
     * @param $value the parameter value
     * @return self
     */
    public function setParameter($key = null, $value = null)
    {
        $this->parameter[$key] = $value;

        return $this;
    }

    /**
     * clearParameter empties parameters
     * @return self
     */
    public function clearParameter()
    {
       // Get current parameters extract key and format
        $current = $this->getParameter();

        $this->parameter = array(
            'key' => isset($current['key']) ? $current['key'] : null,
            'format' => isset($current['format']) ? $current['format'] : null,
        );

        return $this;
    }

    /**
     * buildQueryString
     *
     * @param $params array
     * @return string
     */
    protected function buildQueryString(array $params = array())
    {
        return http_build_query($params, null, '&');
    }

    /**
     * getBaseUrl
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * execute
     *
     * @return mixed
     */
    public function execute()
    {
        // Get curl options
        $curlOptions = $this->getCurlOptions();

        // Init curl
        $curl = curl_init();

        // Set options
        curl_setopt_array($curl, $curlOptions);

        // Execute and save response to $response
        if (!$response = curl_exec($curl)) {
            throw new AvinException('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }

        // Close request to clear up some resources
        curl_close($curl);

        return $result;
    }
}