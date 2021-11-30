<?php

use GuzzleHttp\Client;

class PrintfulShippingRateService
{
    private $cacheService;

    public function __construct()
    {
        $this->cacheService = new CacheService;
    }

    public function retrieveShippingOptions()
    {        
        $printful_api = 'https://api.printful.com/';
        $api_key = '77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7';

        $client = new Client(
            [
                'headers' => [ 'Authorization' => 'Basic ' . base64_encode($api_key) ]
            ]
        );

        $body = json_encode(
            [
                "recipient" => [
                    "address1" => "11025 Westlake Dr",
                    "city" => "Charlotte",
                    "country_code" => "US",
                    "state_code" => "NC",
                    "zip" => 28273,
                ],
                "items" => [
                    [ "quantity" => 2, "variant_id" => 7679 ]
                ]
            ]
        );

        $response = $client->request('POST', $printful_api . 'shipping/rates', [ 'body' => $body ]);

        if ($response->getStatusCode() == 200)
            return json_decode($response->getBody());
        else
            return null;
    }

    public function cacheShippingOptions()
    {
        if ($data = $this->retrieveShippingOptions()) {
            if ($this->cacheService->set("attribute_4", $data, 300)) {
                return true;
            }
        }

        return false;
    }
}