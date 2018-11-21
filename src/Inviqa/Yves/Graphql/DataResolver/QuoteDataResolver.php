<?php

namespace Inviqa\Yves\Graphql\DataResolver;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class QuoteDataResolver extends AbstractDataResolver
{

    public function resolveData($args): AbstractTransfer
    {
        $quoteTransfer = $this->getFactory()->getCartClient()->getQuote();

        $cartItems = $this->getFactory()
            ->getProductBundleClient()
            ->getGroupedBundleItems($quoteTransfer->getItems(), $quoteTransfer->getBundleItems());

        $quoteTransfer->setItems(new \ArrayObject($cartItems));

        return $quoteTransfer;
    }
}
