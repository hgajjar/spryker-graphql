<?php

namespace Inviqa\Yves\Graphql\Plugin\Provider;

use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Application\Plugin\Provider\YvesControllerProvider as SprykerYvesControllerProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class GraphqlControllerProvider extends SprykerYvesControllerProvider
{

    const ROUTE_GRAPHQL = 'graphql';

    protected function defineControllers(Application $app)
    {
        $allowedLocalesPattern = $this->getAllowedLocalesPattern();
        $this->createController('/{graphql}', self::ROUTE_GRAPHQL, 'Graphql', 'Graphql', 'index')
            ->assert('graphql', $allowedLocalesPattern . 'graphql|graphql')
            ->value('graphql', 'graphql')
            ->before(function (Request $request) {
                if ($request->getContentType() === 'json') {
                    $data = json_decode($request->getContent(), true);
                    $request->request->replace(is_array($data) ? $data : array());
                }
            });
    }

    private function getAllowedLocalesPattern()
    {
        $systemLocales = Store::getInstance()->getLocales();
        $implodedLocales = implode('|', array_keys($systemLocales));
        $allowedLocalesPattern = '(' . $implodedLocales . ')\/';

        return $allowedLocalesPattern;
    }

}

