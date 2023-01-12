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
    public function suggests(string $query = '', string $gender = 'common', string $locale = 'ru', string $lang = 'ru'): array
    {
        return $this->request('https://search.wb.ru/suggests/api/v3/hint', [
            'query' => $query,
            'gender' => $gender,
            'locale' => $locale,
            'lang' => $lang,
        ]);
    }
    
    /**
     * Результаты поиска
     * 
     * @param string $query
     * @param int $page
     * @param array $regions
     * @param array $dest
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $filter
     * @param array $couponsGeo
     * @return array
     */
    public function catalog(string $query, int $page, array $regions, array $dest, string $sort = 'popular', array $filter = [], array $couponsGeo = []): object
    {
        return $this->search($query, $page, $regions, $dest, 'catalog', $sort, $filter, $couponsGeo);
    }

    /**
     * Фильтры для результатов поиска
     * 
     * @param string $query
     * @param int $page
     * @param array $regions
     * @param array $dest
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $filter
     * @param array $couponsGeo
     * @return array
     */
    public function filters(string $query, int $page, array $regions, array $dest, string $sort = 'popular', array $filter = [], array $couponsGeo = []): object
    {
        return $this->search($query, $page, $regions, $dest, 'filters', $sort, $filter, $couponsGeo);
    }

    /**
     * @param string $query
     * @param int $page
     * @param array $regions
     * @param array $dest
     * @param string $resultset 'catalog', 'filters'
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $filter
     * @param array $couponsGeo
     * @return array
     */
    public function search(string $query, int $page, array $regions, array $dest, string $resultset = 'catalog', string $sort = 'popular', array $filter = [], array $couponsGeo = []): object
    {
        return $this->request('https://search.wb.ru/exactmatch/ru/common/v4/search', [
            'query' => $query,
            'page' => $page,
            'sort' => $sort,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'resultset' => $resultset,
            'curr' => 'rub',
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'appType' => 1,
            'reg' => 0,
            'spp' => 0,
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
     * @param array $regions
     * @param array $dest
     * @param array $couponsGeo
     * @return object
     */
    public function similarQueries(string $query, array $regions, array $dest, array $couponsGeo = []): object
    {
        return $this->request('https://similar-queries.wildberries.ru/api/v2/search/query', [
            'query' => $query,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => 'rub',
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'appType' => 1,
            'reg' => 0,
            'spp' => 0,
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
