<?php

namespace Inviqa\Yves\Graphql\Schema\Type;

use Inviqa\Yves\Graphql\Schema\Type\Mutation\MutationRegistry;

class MutationType extends AbstractType
{

    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => [
                'addToCart' => MutationRegistry::addToCart()->build()
            ]
        ];
        parent::__construct($config);
    }

}
