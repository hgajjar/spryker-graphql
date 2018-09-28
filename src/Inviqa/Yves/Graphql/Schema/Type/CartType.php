<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use GraphQL\Type\Definition\ResolveInfo;
use Inviqa\Yves\Graphql\Schema\Types;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class CartType extends AbstractType
{

    public function __construct()
    {
        $config = [
            'name' => 'Cart',
            'description' => 'Product cart',
            'fields' => function() {
                return [
                    'items' => [
                        'type' => Types::listOf(Types::cartItem()),
                        'description' => 'Cart item',
                    ],
//                    'total' => Types::float(),
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
