<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Endpoint\AbstractEndpoint;

class Catalog extends AbstractEndpoint
{

    /**
     * Основное меню
     * 
     * @return array
     */
    public function mainMenu(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/main-menu-ru-ru.json');
    }

    /**
     * Персональные предложения для пользователя
     * 
     * @param int $userId
     * @return array
     */
    public function persGoods(int $userId = 0): array
    {
        return $this->request('https://main-page.wildberries.ru/api/v1/pers-goods', [
            'userID' => $userId
        ]);
    }

    /**
     * Данные о поставщике
     * 
     * @param int $supplierId
     * @return object
     */
    public function supplierInfo(int $supplierId): object
    {
        return $this->request('https://suppliers-shipment.wildberries.ru/api/v1/suppliers/' . $supplierId, [], 'GET', [
            'x-client-name' => 'site'
        ]);
    }

    /**
     * Данные о перечне поставщиков
     * 
     * @param array $suppliersIds
     * @return array
     */
    public function suppliersByIds(array $suppliersIds): array
    {
        return $this->request('https://suppliers-shipment.wildberries.ru/api/v1/suppliers/find_by_ids', $suppliersIds, 'POST', [
            'content-type' => 'application/json',
            'x-client-name' => 'site',
        ]);
    }

    /**
     * Бренды "на букву"
     * 
     * @param string $letter a, b, c, ... z, 123, а-я
     * @return type
     */
    public function brandsList(string $letter)
    {
        return $this->request('https://www.wildberries.ru/webapi/wildberries/brandlist/data?letter=' . $letter, [], 'POST');
    }
    
    /**
     * Данные о бренде по идентификатору
     * 
     * @param int $brandId
     * @return object
     */
    public function brandById(int $brandId): object
    {
        return $this->request('https://static.wbstatic.net/data/brands-by-id/' . $brandId . '.json');
    }
    
    /**
     * Данные о бренде по наименованию
     * 
     * @param string $brandName
     * @return object
     */
    public function brandByName(string $brandName): object
    {
        return $this->request('https://static.wbstatic.net/data/brands/' . $brandName . '.json');
    }
    
    /**
     * Количество добавлений бренда в закладки
     * 
     * @param int $brandId
     * @return object
     */
    public function brandVotesById(int $brandId): object
    {
        return $this->request('https://www.wildberries.ru/webapi/favorites/brand/getvotesbyid', [
            'brandId' => $brandId
        ], 'FORM');
    }
    
    public function expressStore(string $latitude, string $longitude)
    {
        return $this->request('https://www.wildberries.ru/webapi/spa/product/expressstore', [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    /**
     * Список ПВЗ
     * 
     * @return array
     */
    public function allPoo(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/all-poo-fr-v2.json');
    }

    /**
     * ПВЗ по перечню идентификаторов
     * 
     * @param array $ids
     * @return object
     */
    public function pooByIds(array $ids): object
    {
        return $this->request('https://www.wildberries.ru/webapi/poo/byids', $ids, 'POST', [
            'content-type' => 'application/json',
        ]);
    }

    public function subjects(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/subject-base.json');
    }

    public function noReturnSubjects(): object
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/no-return-subjects.json');
    }

    public function xInfo()
    {
        return $this->request('https://www.wildberries.ru/webapi/user/get-xinfo-v2', [], 'POST', [
            'x-requested-with' => 'XMLHttpRequest',
        ]);
    }

    /**
     * Товары в разделе
     * 
     * @param string $shard
     * @param int $page
     * @param array $subject
     * @param array $regions
     * @param array $dest
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $couponsGeo
     * @param int $kind
     * @param string $curr
     * @return object
     */
    public function catalog(string $shard, array $filter, int $page, array $subject, array $regions, array $dest, string $sort = 'popular', array $couponsGeo = [], int $kind = 0, string $curr = 'rub'): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/catalog', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => $curr,
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ] + $filter);
    }

    /**
     * Фильтры для товаров в разделе
     * 
     * @param string $shard
     * @param array $filter
     * @param int $page
     * @param int $subject
     * @param array $regions
     * @param array $dest
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $couponsGeo
     * @param string $curr
     * @return object
     */
    public function filter(string $shard, array $filter, int $page, array $subject, array $regions, array $dest, string $sort = 'popular', array $couponsGeo = [], string $curr = 'rub'): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/v4/filters', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => $curr,
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ] + $filter);
    }

    /**
     * Товары поставщика
     * 
     * @param int $supplierId
     * @param int $page
     * @param array $filter
     * @param array $regions
     * @param array $dest
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param array $couponsGeo
     * @param string $curr
     * @return object
     */
    public function sellerCatalog(int $supplierId, int $page, array $filter, array $regions, array $dest, string $sort = 'popular', array $couponsGeo = [], string $curr = 'rub'): object
    {
        return $this->request('https://catalog.wb.ru/sellers/catalog', [
            'page' => $page,
            'supplier' => $supplierId,
            'sort' => $sort,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => $curr,
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ] + $filter);
    }

    /**
     * Филитры для товаров поставщика
     * 
     * @param int $supplierId
     * @param int $page
     * @param array $filter
     * @param array $regions
     * @param array $dest
     * @param array $couponsGeo
     * @param string $curr
     * @return object
     */
    public function sellerCatalogFilter(int $supplierId, int $page, array $filter, array $regions, array $dest, array $couponsGeo = [], string $curr = 'rub'): object
    {
        return $this->request('https://catalog.wb.ru/sellers/v4/filters', [
            'page' => $page,
            'supplier' => $supplierId,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => $curr,
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ] + $filter);
    }
    
    public function setUserLoc(string $address, float $latitude, float $longitude): array
    {
        $this->request('https://www.wildberries.ru/webapi/geo/saveprefereduserloc', [
            'address' => $address,
            'longitude' => $longitude,
            'latitude' => $latitude,
        ], 'FORM', [
            'x-requested-with' => 'XMLHttpRequest'
        ]);
        $headers = $this->responseHeaders();
        $cookies = [];
        foreach($headers['Set-Cookie'] ?? [] as $item) {
            $vars = explode(';', $item);
            list($name, $value) = explode('=', $vars[0]);
            $cookies[$name] = urldecode($value);
        }

        return $cookies;
    }
}
