<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Endpoint\AbstractEndpoint;

class Ads extends AbstractEndpoint
{

    /**
     * Промотовары в результатах поиска
     * 
     * @param string $keyword
     * @return array
     */
    public function inSearch(string $keyword): object
    {
        return $this->request('https://catalog-ads.wildberries.ru/api/v5/search', [
            'keyword' => $keyword,
        ]);
    }

    /**
     * Промотовары в разделе каталога
     * 
     * @param int $menuid
     * @return array
     */
    public function inCatalog(int $menuid): object
    {
        return $this->request('https://catalog-ads.wildberries.ru/api/v5/catalog', [
            'menuid' => $menuid,
        ]);
    }

    /**
     * Промотовары к товару
     * 
     * @param int $nmId
     * @return array
     */
    public function productCarousel(int $nmId): array
    {
        return $this->request('https://carousel-ads.wildberries.ru/api/v4/carousel', [
            'nm' => $nmId,
        ], 'GET', ['wb-apptype' => 1]);
    }

}
