<?php

namespace Inviqa\Yves\Graphql\DataResolver;

use Generated\Shared\Transfer\QuoteTransfer;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class QuoteDataResolver extends AbstractDataResolver
{

    public function resolveData($args): QuoteTransfer
    {
        $quoteTransfer = $this->getFactory()->getCartClient()->getQuote();

        $cartItems = $this->getFactory()
            ->getProductBundleClient()
            ->getGroupedBundleItems($quoteTransfer->getItems(), $quoteTransfer->getBundleItems());

        $quoteTransfer->setItems(new \ArrayObject($cartItems));

        return $quoteTransfer;
    }
}
