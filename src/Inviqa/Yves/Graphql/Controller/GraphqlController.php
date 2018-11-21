<?php

namespace Inviqa\Yves\Graphql\Controller;

use GraphQL\Error\Debug;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Spryker\Yves\Kernel\Controller\AbstractController as SprykerAbstractController;
use Inviqa\Yves\Graphql\Schema\Type\MutationType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class GraphqlController extends SprykerAbstractController
{

    public function indexAction(Request $request)
    {
        $schema = new Schema([
            'query' => $this->getFactory()->createQueryType(),
            'mutation' => new MutationType()
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $request->get('query')
        );

        set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

        return $this->jsonResponse($result->toArray($debug));
    }

}
