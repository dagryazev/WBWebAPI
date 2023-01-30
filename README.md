# Wildberries Web API exploit

Библиотека для эксплуатации API сайта [Wildberries](https://www.wildberries.ru/).

```php

$setup = (new \Dakword\WBWebAPI\Setup(['curr' => 'rub', 'lang' => 'ru']))->withReg(1)->withSpp(20);
$webAPI = new \Dakword\WBWebAPI\WebAPI($setup);
$webAPI->setup()->setRegions([80,64,83,4,38,33,70,68,69,86,75,30,40,48,1,66,31,22,71]);
$webAPI->setup()->setDest([-1029256,-102269,-2162196,-1255942]);

// Endpoints
$Ads = $webAPI->Ads();
$Catalog = $webAPI->Catalog();
$Product = $webAPI->Product();
$Search = $webAPI->Search();
$User = $webAPI->User();

// Карточка товара
$Product->card(13615125);
// Отзывы
$Product->feedbacks(13615125);
// Похожие товары
$Product->similar(13615125);
// История цены
$Product->priceHistory(13615125);

// Товары в категории каталога
$Catalog->category(shard: 'electronic3', category: 9846, page: 1);
// Данные о поставщике
$Catalog->supplierInfo(28976);

// Подсказки для строки поиска
$Search->suggests('телефон');
// С товарами из этого раздела ищут
$Search->similarCatalogQueries('/catalog/dom-i-dacha/kuhnya/kastryuli-i-skovorody');

// Промотовары к товару
$Ads->productCarousel(13615125);

// Получить regions, dest, couponsGeo, ... для заданного адреса
$User->setUserLoc('г Краснодар, Улица Ленина 50', 45.023, 38.97358);

```