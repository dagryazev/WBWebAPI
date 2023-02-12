<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI\Endpoint;

use Dakword\WBWebAPI\Endpoint\AbstractEndpoint;

class Product extends AbstractEndpoint
{

    /**
     * Карточка товара
     * 
     * @param int $nmId
     * @return object
     */
    public function card(int $nmId): object
    {
        return $this->request($this->makeShardUrl($nmId) . '/info/ru/card.json');
    }

    /**
     * Данные о товарах для подборок
     * "Промотовары", "Похожие товары", "С этим товаром покупали", "С товаром рекомендуют"
     * 
     * @param array $nmIds
     * @return object
     */
    public function cardsList(array $nmIds): object
    {
        return $this->request('https://card.wb.ru/cards/list', [
            'nm' => implode(';', $nmIds),
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'appType' => 1,
            'emp' => $this->Setup->emp(),
        ]);
    }

    /**
     * Дутали о товарах
     * 
     * @param array $nmIds
     * @return object
     */
    public function cardsDetail(array $nmIds): object
    {
        return $this->request('https://card.wb.ru/cards/detail', [
            'nm' => implode(';', $nmIds),
            'regions' => implode(',', $this->Setup->regions()),
            'dest' => implode(',', $this->Setup->dest()),
            'couponsGeo' => implode(',', $this->Setup->couponsgeo()),
            'curr' => $this->Setup->curr(),
            'lang' => $this->Setup->lang(),
            'locale' => $this->Setup->locale(),
            'pricemarginCoeff' => $this->Setup->pricemargincoeff(),
            'reg' => $this->Setup->reg(),
            'spp' => $this->Setup->spp(),
            'appType' => 1,
            'emp' => $this->Setup->emp(),
        ]);
    }

    public function data(int $nmId, int $subject, int $brand, int $kind = 0, string $targetUrl = ''): object
    {
        return $this->request('https://www.wildberries.ru/webapi/product/' . $nmId . '/data',
            [
                'subject' => $subject,
                'brand' => $brand,
            ]
            + ($targetUrl ? ['targetUrl' => $targetUrl] : [])
            + ($kind ? ['kind' => $kind] : [])
        );
    }

    /**
     * История цены
     * 
     * @param int $nmId
     * @return array
     */
    public function priceHistory(int $nmId): array
    {
        return $this->request($this->makeShardUrl($nmId) . '/info/price-history.json');
    }

    /**
     * Реквизиты продавца
     * 
     * @param int $nmId
     * @return object
     */
    public function seller(int $nmId): object
    {
        return $this->request($this->makeShardUrl($nmId) . '/info/sellers.json');
    }

    /**
     * Сколько купили
     * 
     * @param string|array $nmId
     * @return array
     */
    public function orderQnt(string|array $nmId): array
    {
        return $this->request('https://product-order-qnt.wildberries.ru/by-nm', [
            'nm' => implode(',', is_array($nmId) ? $nmId : [$nmId])
        ]);
    }

    /**
     * Похожие товары
     * 
     * @param int $nmId
     * @return array
     */
    public function similar(int $nmId): array
    {
        return $this->request('https://in-similar.wildberries.ru', [
            'nm' => $nmId
        ]);
    }

    /**
     * Предложения других продавцов
     * 
     * @param int $nmId
     * @return array
     */
    public function identical(int $nmId): array
    {
        return $this->request('https://identical-products.wildberries.ru/api/v1/identical', [
            'nmID' => $nmId
        ]);
    }

    /**
     * Количество вопросов
     * 
     * @param int $imtId
     * @return int
     */
    public function questionsCount(int $imtId): int
    {
        return $this->request('https://questions.wildberries.ru/api/v1/questions', [
            'imtId' => $imtId,
            'onlyCount' => 'true',
        ])->count;
    }

    /**
     * Вопросы
     * 
     * @param int $imtId
     * @return array
     */
    public function questions(int $imtId): array
    {
        $questions = [];
        $take = 30;
        $page = 1;
        do {
            $part = $this->request('https://questions.wildberries.ru/api/v1/questions', [
                'imtId' => $imtId,
                'take' => $take,
                'skip' => ($page - 1) * $take,
            ]);
            $questions = array_merge($questions, ($part->questions ?: []));
            $page++;
        } while ($part->questions && count($part->questions) > 0);
        
        return $questions;
    }

    /**
     * Отзывы
     * 
     * @param int $imtId
     * @return object
     */
    public function feedbacks(int $imtId): object
    {
        return $this->request('https://feedbacks2.wb.ru/feedbacks/v1/' . $imtId);
    }

    /**
     * С товаром рекомендуют
     * 
     * @param int $nmId
     * @return object
     */
    public function recomendations(int $nmId): object
    {
        return $this->request('https://rec-goods.wildberries.ru/api/v1/recommendations', [
            'nm' => $nmId,
        ]);
    }

    /**
     * С этим товаром покупали
     * 
     * @param int $nmId
     * @return array
     */
    public function inComp(int $nmId): array
    {
        return $this->request('https://in-comp.wildberries.ru/', [
            'nm' => $nmId,
        ]);
    }

    /**
     * C этим товаром искали
     * 
     * @param int $nmId
     * @return array
     */
    public function tags(int $nmId): array
    {
        return $this->request('https://search-tags.wildberries.ru/tags', [
            'nm_id' => $nmId,
        ]) ?: [];
    }
    
   
    // ---

    private function makeShardUrl(int $num)
    {
        $n3 = (int) ($num / 1_000);
        $n5 = (int) ($num / 1_00000);
        $host = function($t) {
            return $t >= 0 && $t <= 143 
                ? "basket-01.wb.ru" 
                : ($t >= 144 && $t <= 287 
                    ? "basket-02.wb.ru"
                    : ($t >= 288 && $t <= 431
                        ? "basket-03.wb.ru"
                        : ($t >= 432 && $t <= 719
                            ? "basket-04.wb.ru"
                            : ($t >= 720 && $t <= 1007 
                                ? "basket-05.wb.ru" 
                                : ($t >= 1008 && $t <= 1061
                                    ? "basket-06.wb.ru"
                                    : ($t >= 1062 && $t <= 1115
                                        ? "basket-07.wb.ru"
                                        : ($t >= 1116 && $t <= 1169 
                                            ? "basket-08.wb.ru"
                                            : ($t >= 1170 && $t <= 1313
                                                ? "basket-09.wb.ru"
                                                : "basket-10.wb.ru"
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            ;
        };
        return "https://" . $host($n5) .  "/vol" . $n5 . "/part"  . $n3 . "/" . $num;
    }
}
