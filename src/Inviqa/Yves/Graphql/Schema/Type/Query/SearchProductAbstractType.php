<?php

namespace Inviqa\Yves\Graphql\Schema\Type\Query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class SearchProductAbstractType extends ObjectType
{

    public function __construct()
    {
        $config = [
            'name' => 'SearchProductAbstract',
            'description' => 'SearchProductAbstract',
            'fields' => function() {
                return [
                    'id_product_abstract' => [
                        'type' => Type::int()
                    ],
                    'abstract_sku' => [
                        'type' => Type::string()
                    ],
                    'abstract_name' => [
                        'type' => Type::string()
                    ],
                    'type' => [
                        'type' => Type::string()
                    ],
                    'price' => [
                        'type' => Type::int()
                    ],
                ];
            },
        ];
        parent::__construct($config);
    }

}
