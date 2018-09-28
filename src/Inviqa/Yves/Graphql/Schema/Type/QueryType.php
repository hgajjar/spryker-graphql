<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use Generated\Shared\Graphql\Types\TypeRegistry;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Inviqa\Yves\Graphql\DataResolver\FeaturedProductsDataResolver;
use Inviqa\Yves\Graphql\DataResolver\NavigationDataResolver;
use Inviqa\Yves\Graphql\DataResolver\QuoteDataResolver;
use Inviqa\Yves\Graphql\Schema\Type\Query\SearchProductAbstractType;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class QueryType extends AbstractType
{

    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'quote' => [
                    'type' => TypeRegistry::QuoteType(),
                    'description' => 'Return cart items',
                ],
                'navigation' => [
                    'type' => TypeRegistry::NavigationTreeType(),
                    'description' => 'Return navigation tree'
                ],
                'featuredProducts' => [
                    'type' => Type::listOf(new SearchProductAbstractType()),
                    'description' => 'Return featured products'
                ]
            ],
            'resolveField' => function($val, $args, $context, ResolveInfo $info) {
                switch ($info->fieldName) {
                    case 'quote':
                        $resolver = new QuoteDataResolver();
                        return $resolver->resolveData($args);
                    case 'navigation':
                        $resolver = new NavigationDataResolver();
                        return $resolver->resolveData($args);
                    case 'featuredProducts':
                        $resolver = new FeaturedProductsDataResolver();
                        return $resolver->resolveData($args);
                }
            }
        ];
        parent::__construct($config);
    }

}
