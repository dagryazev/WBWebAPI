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
        return $this->request('https://static-basket-01.wb.ru/vol0/data/main-menu-ru-ru-v2.json');
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
     * Основные данные о поставщике
     * 
     * @param int $sellerId
     * @return object
     */
    public function supplierShortInfo(int $sellerId): object
    {
        return $this->request('https://www.wildberries.ru/webapi/seller/data/short/' . $sellerId);
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
    
    /**
     * Перечень "премиальных брендов"
     * 
     * @return array
     */
    public function premiumBrands(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/brands-premium-ru.json');
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

    /**
     * Справочник категорий товаров
     * 
     * @return array
     */
    public function subjects(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/subject-base.json');
    }

    public function noReturnSubjects(): object
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/no-return-subjects.json');
    }

    /**
     * Идентификаторы предметов категории "для взрослых"
     * 
     * @return array
     */
    public function adultSubjects(): array
    {
        return $this->request('https://static-basket-01.wb.ru/vol0/data/adult-subjects.json');
    }

    /**
     * Товары в категории
     * 
     * @param string $shard
     * @param int $category
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return object
     */
    public function category(string $shard, int $category, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/catalog', [
            'appType' => 1,
            'cat' => $category,
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'dest' => implode(',', $this->Setup->dest()),
            'emp' => $this->Setup->emp(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'page' => $page,
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'regions' => implode(',', $this->Setup->regions()),
            'sort' => $sort,
            'spp' => $this->Setup->spp(),
        ] + $filter);
    }

    /**
     * Фильтр для категории
     * 
     * @param string $shard
     * @param int $category
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return object
     */
    public function categoryFilter(string $shard, int $category, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/v4/filters', [
            'appType' => 1,
            'cat' => $category,
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'dest' => implode(',', $this->Setup->dest()),
            'emp' => $this->Setup->emp(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'page' => $page,
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'regions' => implode(',', $this->Setup->regions()),
            'sort' => $sort,
            'spp' => $this->Setup->spp(),
        ] + $filter);
    }

    /**
     * Товары в разделе
     * 
     * @param string $shard
     * @param array $subject
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param int $kind
     * @return object
     */
    public function catalog(string $shard, array $subject, array $filter = [], int $page = 1, string $sort = 'popular', int $kind = 0): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/catalog', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'emp' => $this->Setup->emp(),
        ] + $filter);
    }

    /**
     * Фильтры для товаров в разделе
     * 
     * @param string $shard
     * @param int $subject
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param int $kind
     * @return object
     */
    public function filter(string $shard, array $subject, array $filter = [], int $page = 1, string $sort = 'popular', int $kind = 0): object
    {
        return $this->request('https://catalog.wb.ru/catalog/' . $shard . '/v4/filters', [
            'page' => $page,
            'subject' => implode(';', $subject),
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'emp' => $this->Setup->emp(),
        ] + $filter);
    }

    /**
     * Товары поставщика
     * 
     * @param int $supplierId
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param int $kind
     * @return object
     */
    public function sellerCatalog(int $supplierId, array $filter = [], int $page = 1, string $sort = 'popular', int $kind = 0): object
    {
        return $this->request('https://catalog.wb.ru/sellers/catalog', [
            'page' => $page,
            'supplier' => $supplierId,
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'emp' => $this->Setup->emp(),
        ] + $filter);
    }

    /**
     * Филитры для товаров поставщика
     * 
     * @param int $supplierId
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @param int $kind
     * @return object
     */
    public function sellerCatalogFilter(int $supplierId, array $filter = [], int $page = 1, string $sort = 'popular', int $kind = 0): object
    {
        return $this->request('https://catalog.wb.ru/sellers/v4/filters', [
            'page' => $page,
            'supplier' => $supplierId,
            'sort' => $sort,
            'kind' => $kind,
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'emp' => $this->Setup->emp(),
        ] + $filter);
    }

    /**
     * Каталог бренда
     * 
     * @param string $shard
     * @param array $brandId
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return object
     */
    public function brandCatalog(string $shard, int $brandId, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->request('https://catalog.wb.ru/brands/' . $shard . '/catalog', [
            'appType' => 1,
            'brand' => $brandId,
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'dest' => implode(',', $this->Setup->dest()),
            'emp' => $this->Setup->emp(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'page' => $page,
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'regions' => implode(',', $this->Setup->regions()),
            'sort' => $sort,
            'spp' => $this->Setup->spp(),
        ] + $filter);
    }

    /**
     * Фильтр для каталога бренда
     * 
     * @param string $shard
     * @param int $brandId
     * @param array $filter
     * @param int $page
     * @param string $sort 'popular', 'rate', 'priceup', 'pricedown', 'newly', 'benefit'
     * @return object
     */
    public function brandCatalogFilter(string $shard, int $brandId, array $filter = [], int $page = 1, string $sort = 'popular'): object
    {
        return $this->request('https://catalog.wb.ru/brands/' . $shard . '/v4/filters', [
            'appType' => 1,
            'brand' => $brandId,
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'dest' => implode(',', $this->Setup->dest()),
            'emp' => $this->Setup->emp(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'page' => $page,
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'regions' => implode(',', $this->Setup->regions()),
            'sort' => $sort,
            'spp' => $this->Setup->spp(),
        ] + $filter);
    }
    
}
