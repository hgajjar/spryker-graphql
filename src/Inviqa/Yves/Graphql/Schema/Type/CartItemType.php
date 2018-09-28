<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use GraphQL\Type\Definition\ResolveInfo;
use Inviqa\Yves\Graphql\Schema\Types;

class CartItemType extends AbstractType
{

    public function __construct()
    {
        $config = [
            'name' => 'CartItem',
            'description' => 'Cart item',
            'fields' => function() {
                return [
                    'sku' => Types::string(),
                    'quantity' => Types::int(),
                    'name' => Types::string(),
                ];
            },
            'resolveField' => function($value, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($value, $args, $context, $info);
                } else {
                    return $value->{"get".ucwords($info->fieldName)}();
                }
            }
        ];
        parent::__construct($config);
    }

}
