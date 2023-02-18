<?php

namespace Dakword\WBWebAPI\Tests;

use Dakword\WBWebAPI\Tests\TestCase;

class ProductTest extends TestCase
{

    public function test_Card(): void
    {
        $Product = $this->Product();

        $nmId = $this->randomNmId();
        $card = $Product->card($nmId);

        $this->assertIsObject($card, $Product->requestPath());
        $this->assertEquals($nmId, $card->nm_id);
    }

    public function test_cardsList(): void
    {
        $Product = $this->Product();

        $nmId1 = $this->randomNmId();
        $nmId2 = $this->randomNmId();
        $nmId3 = $this->randomNmId();
        $nmId4 = $this->randomNmId();
        $nmId5 = $this->randomNmId();

        $cards = $Product->cardsList([$nmId1, $nmId2, $nmId3, $nmId4, $nmId5]);

        $this->assertIsObject($cards, $Product->requestPath());
        $this->assertIsArray($cards->data->products, $Product->requestPath());
    }

    public function test_cardsDetail(): void
    {
        $Product = $this->Product();

        $nmId1 = $this->randomNmId();
        $nmId2 = $this->randomNmId();
        $nmId3 = $this->randomNmId();
        $nmId4 = $this->randomNmId();
        $nmId5 = $this->randomNmId();

        $cards = $Product->cardsDetail([$nmId1, $nmId2, $nmId3, $nmId4, $nmId5]);

        $this->assertIsObject($cards, $Product->requestPath());
        $this->assertIsArray($cards->data->products, $Product->requestPath());
    }

    public function test_priceHistory(): void
    {
        $Product = $this->Product();

        $nmId = $this->randomNmId();

        $history = $Product->priceHistory($nmId);

        $this->assertIsArray($history, $Product->requestPath());
        if ($history) {
            $first = array_shift($history);
            $this->assertObjectHasAttribute('dt', $first);
            $this->assertObjectHasAttribute('price', $first);
        }
    }

    public function test_seller(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $seller = $Product->seller($nmId);

        $this->assertIsObject($seller, $Product->requestPath());
        $this->assertEquals($nmId, $seller->nmId, $Product->requestPath());
        $this->assertObjectHasAttribute('supplierId', $seller, $Product->requestPath());
    }

    public function test_similar(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->similar($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_visualSimilar(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->visualSimilar($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_identical(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->identical($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_orderQnt(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->orderQnt($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_questionsCount(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->questionsCount($nmId);

        $this->assertIsInt($result, $Product->requestPath());
    }

    public function test_questions(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->questions($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_inComp(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->inComp($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

    public function test_feedbacks(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->feedbacks($nmId);

        $this->assertObjectHasAttribute('feedbacks', $result, $Product->requestPath());
        $this->assertObjectHasAttribute('feedbackCount', $result, $Product->requestPath());
    }

    public function test_recomendations(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->recommendations($nmId);

        $this->assertObjectHasAttribute('nms', $result, $Product->requestPath());
        $this->assertObjectHasAttribute('services', $result, $Product->requestPath());
    }

    public function test_tags(): void
    {
        $Product = $this->Product();
        $nmId = $this->randomNmId();

        $result = $Product->tags($nmId);

        $this->assertIsArray($result, $Product->requestPath());
    }

}
