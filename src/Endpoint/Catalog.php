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

    
    public function expressStore($latitude, $longitude)
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
     * @return object
     */
    public function catalog(string $shard, int $page, array $subject, array $regions, array $dest, string $sort = 'popular', array $couponsGeo = [], int $kind = 0): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/catalog', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => 'rub',
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ]);
    }

    public function filter(string $shard, array $filter, int $page, int $subject, array $regions, array $dest, string $sort = 'popular', array $couponsGeo = []): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/v4/filters', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort, // popular rate priceup pricedown newly benefit
            'regions' => implode(',', $regions),
            'dest' => implode(',', $dest),
            'couponsGeo' => implode(',', $couponsGeo),
            'curr' => 'rub',
            'lang' => 'ru',
            'locale' => 'ru',
            'pricemarginCoeff' => '1.0',
            'reg' => 0,
            'spp' => 0,
            'emp' => 0,
        ] + $filter);
    }
    
}
