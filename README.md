# Wildberries Web API exploit

Библиотека для эксплуатации API сайта [Wildberries](https://www.wildberries.ru/).

```php

$webAPI = new \Dakword\WBWebAPI\WebAPI();

// Endpoints
$Ads = $webAPI->Ads();
$Catalog = $webAPI->Catalog();
$Product = $webAPI->Product();
$Search = $webAPI->Search();

// Карточка товара
$Product->card(13615125);
// Отзывы
$Product->feedbacks(13615125);
// Похожие товары
$Product->similar(13615125);
// История цены
$Product->priceHistory(13615125);

// Товары в разделе
$Catalog->catalog(page: 1, shard: 'electronic3', subject: [515], filter: [], regions: [80,64,83,4,38,33,70,68,69,86,75,30,40,48,1,66,31,22,71], dest: [-1029256,-102269,-2162196,-1255942]);
// Данные о поставщике
$Catalog->supplierInfo(28976);

// Подсказки для строки поиска
$Search->suggests('телефон');
// С товарами из этого раздела ищут
$Search->similarCatalogQueries('/catalog/dom-i-dacha/kuhnya/kastryuli-i-skovorody');

// Промотовары к товару
$Ads->productCarousel(13615125);

```