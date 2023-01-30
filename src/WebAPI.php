<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI;

use Dakword\WBWebAPI\Setup;
use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;
use Dakword\WBWebAPI\Endpoint\User;

class WebAPI
{
    private Setup $Setup;
    
    function __construct(?Setup $setup = null)
    {
        if(is_null($setup)) {
            $this->Setup = new Setup();
        } else {
            $this->Setup = $setup;
        }
    }

    public function Setup(): Setup
    {
        return $this->Setup;
    }

    public function Ads(): Ads
    {
        return new Ads($this->Setup);
    }

    public function Catalog(): Catalog
    {
        return new Catalog($this->Setup);
    }

    public function Product(): Product
    {
        return new Product($this->Setup);
    }

    public function Search(): Search
    {
        return new Search($this->Setup);
    }

    public function User(): User
    {
        return new User($this->Setup);
    }

}
