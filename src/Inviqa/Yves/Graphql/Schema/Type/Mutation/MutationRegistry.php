<?php

namespace Inviqa\Yves\Graphql\Schema\Type\Mutation;

class MutationRegistry
{

    private static $addToCart;

    public static function addToCart()
    {
        return self::$addToCart ?: (self::$addToCart = new AddToCart());
    }

}
