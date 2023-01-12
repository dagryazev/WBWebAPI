<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI;

use Dakword\WBWebAPI\Endpoint\Ads;
use Dakword\WBWebAPI\Endpoint\Catalog;
use Dakword\WBWebAPI\Endpoint\Product;
use Dakword\WBWebAPI\Endpoint\Search;

class WebAPI
{

    public function Ads(): Ads
    {
        return new Ads();
    }

    public function Catalog(): Catalog
    {
        return new Catalog();
    }

    public function Product(): Product
    {
        return new Product();
    }

    public function Search(): Search
    {
        return new Search();
    }

}
