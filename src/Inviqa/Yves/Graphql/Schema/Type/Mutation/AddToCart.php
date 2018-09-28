<?php

namespace Inviqa\Yves\Graphql\Schema\Type\Mutation;

use Generated\Shared\Graphql\Types\TypeRegistry;
use GraphQL\Type\Definition\Type;
use Inviqa\Yves\Graphql\DataResolver\QuoteDataResolver;

class AddToCart extends AbstractMutationType
{

    public function build()
    {
        return [
            'name' => 'addToCart',
            'args' => [
                'sku' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int())
            ],
            'type' => TypeRegistry::QuoteType(),
            'resolve' => function($object, $args) {
                $cartOperationHandler = $this->getCartOperationHandler();
                $cartOperationHandler->add($args['sku'], $args['quantity']);
                $resolver = new  QuoteDataResolver();
                return $resolver->resolveData($args);
            }
        ];
    }

    /**
     * @return \Pyz\Yves\Cart\Handler\ProductBundleCartOperationHandler
     */
    protected function getCartOperationHandler()
    {
        return $this->getFactory()->createProductBundleCartOperationHandler();
    }

}
