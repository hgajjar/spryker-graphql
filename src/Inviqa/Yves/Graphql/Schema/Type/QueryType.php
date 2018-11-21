<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use Inviqa\Yves\Graphql\Plugin\AbstractGraphqlPlugin;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class QueryType extends AbstractType
{

    /**
     * @param $graphqlPlugins array|AbstractGraphqlPlugin[]
     */
    public function __construct(array $graphqlPlugins)
    {
        $fields = [];
        foreach ($graphqlPlugins as $plugin) {
            $fields[$plugin->getFieldName()] = [
                'type' => $plugin->getFieldType(),
                'description' => $plugin->getFieldDescription(),
            ];
        }

        $config = [
            'name' => 'Query',
            'fields' => $fields,
            'resolveField' => function($val, $args, $context, ResolveInfo $info) use ($graphqlPlugins) {
                foreach ($graphqlPlugins as $plugin) {
                    if ($plugin->getFieldName() === $info->fieldName) {
                        return $plugin->resolveField($args);
                    }
                }
            }
        ];

        parent::__construct($config);
    }

}
