<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Endpoint\AbstractEndpoint;

class Search extends AbstractEndpoint
{

    /**
     * Подсказки для строки поиска
     * 
     * @param string $query
     * @param string $gender "common", "male", "female"
     * @param string $locale
     * @param string $lang
     * @return array
     */
    public function suggests(string $query = '', string $gender = 'common'): array
    {
        return $this->request('https://search.wb.ru/suggests/api/v3/hint', [
            'query' => $query,
            'gender' => $gender,
            'locale' => $this->Setup->locale(),
            'lang' => $this->Setup->lang(),
        ]);
    }
    
    /**
     * Результаты поиска
     * 
     * @param string $query
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return array
     */
    public function catalog(string $query, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->search($query, $filter,  $page, 'catalog', $sort);
    }

    /**
     * Фильтры для результатов поиска
     * 
     * @param string $query
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return array
     */
    public function filters(string $query, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->search($query, $filter, $page, 'filters', $sort);
    }

    /**
     * @param string $query
     * @param array $filter
     * @param int $page
     * @param string $resultset 'catalog', 'filters'
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return array
     */
    public function search(string $query, array $filter = [], int $page = 1, string $resultset = 'catalog', string $sort = 'popular'): object
    {
        return $this->request('https://search.wb.ru/exactmatch/ru/common/v4/search', [
            'query' => $query,
            'page' => $page,
            'sort' => $sort,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsGeo()),
            'resultset' => $resultset,
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemarginCoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'appType' => 1,
            'emp' => 0,
            'suppressSpellcheck' => 'false',
        ] + $filter);
    }

    /**
     * С товарами из этого раздела ищут
     * 
     * @param string $url
     * @return array
     */
    public function similarCatalogQueries(string $url): array
    {
        return $this->request('https://similar-queries.wildberries.ru/catalog', [
            'url' => $url,
        ]);
    }

    /**
     * С этим запросом ищут
     * 
     * @param string $query
     * @return object
     */
    public function similarQueries(string $query): object
    {
        return $this->request('https://similar-queries.wildberries.ru/api/v2/search/query', [
            'query' => $query,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsGeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemarginCoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'appType' => 1,
            'emp' => 0,
        ]);
    }

    /**
     * Рекомендованные товары в результатах поиска
     * "Возможно, вам понравится"
     * 
     * @param string $query
     * @return array
     */
    public function recomendations(string $query): array
    {
        return $this->request('https://search-goods.wildberries.ru/search', [
            'query' => $query,
        ]);
    }

}
