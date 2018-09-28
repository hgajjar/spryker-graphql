<?php

namespace Inviqa\Yves\Graphql\Schema;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;
use Inviqa\Yves\Graphql\Schema\Type\CartItemType;
use Inviqa\Yves\Graphql\Schema\Type\CartType;
use Inviqa\Yves\Graphql\Schema\Type\QueryType;

class Types
{

    private static $query;
    private static $cart;
    private static $cartItem;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function cart()
    {
        return self::$cart ?: (self::$cart = new CartType());
    }

    public static function cartItem()
    {
        return self::$cartItem ?: (self::$cartItem = new CartItemType());
    }

    public static function string()
    {
        return Type::string();
    }

    public static function float()
    {
        return Type::float();
    }

    public static function int()
    {
        return Type::int();
    }

    public static function listOf($type)
    {
        return new ListOfType($type);
    }

}
