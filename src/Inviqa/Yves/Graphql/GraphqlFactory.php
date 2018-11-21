<?php

namespace Inviqa\Yves\Graphql;

use Inviqa\Yves\Graphql\Schema\Type\QueryType;
use Pyz\Client\Catalog\CatalogClientInterface;
use Pyz\Yves\Cart\Handler\CartOperationHandler;
use Pyz\Yves\Cart\Handler\ProductBundleCartOperationHandler;
use Spryker\Client\Cart\CartClientInterface;
use Spryker\Client\Navigation\NavigationClientInterface;
use Spryker\Client\ProductBundle\ProductBundleClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class GraphqlFactory extends AbstractFactory
{

    public function getCartClient(): CartClientInterface
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::CLIENT_CART);
    }

    public function getProductBundleClient(): ProductBundleClientInterface
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::PRODUCT_BUNDLE_CLIENT);
    }

    /**
     * @return \Pyz\Yves\Cart\Handler\ProductBundleCartOperationHandler
     */
    public function createProductBundleCartOperationHandler()
    {
        return new ProductBundleCartOperationHandler(
            $this->createCartOperationHandler(),
            $this->getCartClient(),
            $this->getLocale(),
            $this->getFlashMessenger()
        );
    }

    /**
     * @return \Pyz\Yves\Cart\Handler\CartOperationHandler
     */
    public function createCartOperationHandler()
    {
        return new CartOperationHandler(
            $this->getCartClient(),
            $this->getLocale(),
            $this->getFlashMessenger(),
            $this->getRequest(),
            $this->getAvailabilityClient()
        );
    }

    /**
     * @return \Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface
     */
    protected function getFlashMessenger()
    {
        return $this->getApplication()['flash_messenger'];
    }

    /**
     * @return string
     */
    protected function getLocale()
    {
        return $this->getApplication()['locale'];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->getApplication()['request'];
    }

    /**
     * @return \Spryker\Yves\Kernel\Application
     */
    protected function getApplication()
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::PLUGIN_APPLICATION);
    }

    /**
     * @return \Spryker\Client\Availability\AvailabilityClientInterface
     */
    protected function getAvailabilityClient()
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::CLIENT_AVAILABILITY);
    }

    public function getNavigationClient(): NavigationClientInterface
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::CLIENT_NAVIGATION);
    }

    public function getCatalogClient(): CatalogClientInterface
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::CLIENT_CATALOG);
    }

    public function getGraphqlPlugins(): array
    {
        return $this->getProvidedDependency(GraphqlDependencyProvider::PLUGIN_GRAPHQL);
    }

    public function createQueryType(): QueryType
    {
        return new QueryType($this->getGraphqlPlugins());
    }
}
