<?php

namespace Inviqa\Yves\Graphql;

use Pyz\Yves\Application\Plugin\ApplicationGraphqlPlugin;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;

class GraphqlDependencyProvider extends AbstractBundleDependencyProvider
{

    const CLIENT_CART = 'cart client';
    const PRODUCT_BUNDLE_CLIENT = 'product bundle client';
    const CLIENT_AVAILABILITY = 'availability client';
    const CLIENT_NAVIGATION = 'navigation client';
    const CLIENT_CATALOG = 'catalog client';

    const PLUGIN_APPLICATION = 'application plugin';

    const PLUGIN_GRAPHQL = 'graphql plugins';

    public function provideDependencies(Container $container): Container
    {
        $container[static::CLIENT_CART] = function (Container $container) {
            return $container->getLocator()->cart()->client();
        };

        $container[static::PRODUCT_BUNDLE_CLIENT] = function (Container $container) {
            return $container->getLocator()->productBundle()->client();
        };

        $container[static::CLIENT_AVAILABILITY] = function (Container $container) {
            return $container->getLocator()->availability()->client();
        };

        $container[static::CLIENT_NAVIGATION] = function (Container $container) {
            return $container->getLocator()->navigation()->client();
        };

        $container[static::CLIENT_CATALOG] = function (Container $container) {
            return $container->getLocator()->catalog()->client();
        };

        $container = $this->providePlugins($container);

        return parent::provideDependencies($container);
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function providePlugins(Container $container)
    {
        $container[self::PLUGIN_APPLICATION] = function () {
            $pimplePlugin = new Pimple();

            return $pimplePlugin->getApplication();
        };

        $container[self::PLUGIN_GRAPHQL] = function() {
            return [
                new ApplicationGraphqlPlugin()
            ];
        };

        return $container;
    }


}
