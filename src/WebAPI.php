<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI;

use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;
use Dakword\WBWebAPI\Endpoint\User;
use GuzzleHttp\Client as HttpClient;

class WebAPI
{
    private Setup $Setup;

    private Client $Client;

    function __construct(?Setup $setup = null, ?Client $client = null)
    {
        if(is_null($setup)) {
            $this->Setup = new Setup();
        } else {
            $this->Setup = $setup;
        }

        if (is_null($client)) {
            $this->Client = new Client(
                new HttpClient([
                    'timeout' => 5, // in seconds
                    'verify' => false,
                ])
            );
        } else {
            $this->Client = $client;
        }
    }

    public function Setup(): Setup
    {
        return $this->Setup;
    }

    public function Ads(): Ads
    {
        return new Ads($this->Setup, $this->Client);
    }

    public function Catalog(): Catalog
    {
        return new Catalog($this->Setup, $this->Client);
    }

    public function Product(): Product
    {
        return new Product($this->Setup, $this->Client);
    }

    public function Search(): Search
    {
        return new Search($this->Setup, $this->Client);
    }

    public function User(): User
    {
        return new User($this->Setup, $this->Client);
    }

}
