<?php declare(strict_types=1);

namespace Sas\RelatedProductsCarousel\Subscriber;

use Sas\RelatedProductsCarousel\Page\ProductDetails\ProductDetails;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;

class productDetailSubscriber implements EventSubscriberInterface
{


    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onAddRelatedProductsCarousel',

        ];
    }

    public function onAddRelatedProductsCarousel(ProductPageLoadedEvent $event)
    {
        $productData = new ProductDetails($this->productRepository);
        $productData->getRelatedProducts($event);

    }
}
