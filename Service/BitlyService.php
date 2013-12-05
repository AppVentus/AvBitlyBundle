<?php

namespace AppVentus\AvBitlyBundle\Service;

/**
 * BitlyService
 *
 * Service for the Bitly API v3
 **/
class BitlyService
{
    private $apiAdress = null;
    private $token = null; //user token of the bitly api
    private $domain = null;

    /**
     * Constructor
     *
     * @param string $apiAdress   The bitly api address
     * @param string $bitlyToken  The bitly user token
     * @param string $bitlyDomain The bitly user domain
     */
    public function __construct($apiAdress, $bitlyToken, $bitlyDomain)
    {
        $this->apiAdress = $apiAdress;
        $this->token = $bitlyToken;
        $this->domain = $bitlyDomain;
    }

    /**
     * Shorten url
     *
     * @param string $longUrl
     * @param string $domain
     *
     * @return string the shorten url
     */
    public function shorten($longUrl, $domain = null)
    {
        $urlApi = $this->apiAdress;
        $urlAction = '/v3/shorten?';
        $urlToken = 'access_token='.$this->token;
        $urlLongUrl= '&longUrl='.$longUrl;

        //domain is specified we use it
        if ($domain !== null) {
            $urlDomain = '&domain='.$domain;
        } else {
            //if there is a default domain
            if ($this->domain !== null) {
                $urlDomain = '&domain='.$this->domain;
            } else {
                //no domain specified
                $urlDomain = '';
            }
        }

        $completeUrl = $urlApi.$urlAction.$urlToken.$urlLongUrl;

        $response = $this->bitly_get_curl($completeUrl);
        /*
         * the response expected
         * see http://dev.bitly.com/links.html#v3_shorten
         * {
              "data": {
                "global_hash": "900913",
                "hash": "ze6poY",
                "long_url": "http://google.com/",
                "new_hash": 0,
                "url": "http://bit.ly/ze6poY"
              },
              "status_code": 200,
              "status_txt": "OK"
            }
         */

        $data = $response->data;
        $shortUrl = $data->url;

        return $shortUrl;
    }

    /**
     * Bitly get curl
     *
     * It uses curl in order to get the response of bitly
     *
     * @param string $uri
     * @return array
     */
    private function bitly_get_curl($uri)
    {
        $output = "";

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);

        $outputObject = json_decode($output);
        // @codingStandardsIgnoreStart
        if ($outputObject->status_code === 500) {
        	switch ($outputObject->status_txt) {
        	    // @codingStandardsIgnoreStart
        		case 'INVALID_ARG_ACCESS_TOKEN':
        		    throw new \Exception('The token provided for the bitly API is not valid');
        		default:
        		    throw new \Exception('An error occured using the bitly api service');
        	}
        }
        return $outputObject;
    }
}
