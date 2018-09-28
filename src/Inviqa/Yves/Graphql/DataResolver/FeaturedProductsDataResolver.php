<?php

namespace Inviqa\Yves\Graphql\DataResolver;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class FeaturedProductsDataResolver extends AbstractDataResolver
{

    const FEATURED_PRODUCT_LIMIT = 6;

    public function resolveData($args): array
    {
        $searchResult = $this->getFactory()
            ->getCatalogClient()
            ->getFeaturedProducts(self::FEATURED_PRODUCT_LIMIT);

        return $searchResult['products'];
    }

}
