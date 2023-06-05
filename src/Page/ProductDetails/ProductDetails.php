<?php declare(strict_types=1);

namespace Sas\RelatedProductsCarousel\Page\ProductDetails;

use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;

class ProductDetails
{

    private EntityRepository $productRepository;

    public function __construct( EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function getRelatedProducts(ProductPageLoadedEvent $event): void
    {

        $productData = $event->getPage()->getProduct();

        if (empty($productData->getCategoryIds())) {
            return;
        }
        $criteria = (new Criteria())
            ->addAssociation('cover')
            ->setLimit(8);
        $criteria->addFilter(new EqualsAnyFilter('categories.id', $productData->getCategoryIds()));
        $criteria->addFilter(new EqualsFilter('active', true));
        $criteria->addFilter(new EqualsFilter('parentId', null));
        $criteria->addFilter(
            new NotFilter(
                NotFilter::CONNECTION_OR,
                [
                    new EqualsFilter('id', $productData->getId()),
                    new EqualsFilter('id', $productData->getParentId()),
                ]
            )
        );


        $results = $this->productRepository->search($criteria, $event->getContext())->getEntities()->getElements();

        $products = array_merge(['similarProduct' => $results], $productData->getCustomFields());
        $productData = $event->getPage()->getProduct();

        $productData->setCustomFields(
            array_merge($products, $productData->getCustomFields())
        );

    }
}
