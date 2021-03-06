<?php

namespace Inviqa\Yves\Graphql\DataResolver;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

/**
 * @method \Inviqa\Yves\Graphql\GraphqlFactory getFactory()
 */
class NavigationDataResolver extends AbstractDataResolver
{

    /**
     * Query depends on how depth the tree is required
     * ex:
     *
     * navigation {
     *    nodes {
     *      navigationNode {
     *        idNavigationNode
     *        navigationNodeLocalizedAttributes {
     *          title
     *        }
     *      }
     *      children {
     *        navigationNode {
     *          idNavigationNode
     *          navigationNodeLocalizedAttributes {
     *            title
     *          }
     *        }
     *        children {
     *          navigationNode {
     *            idNavigationNode
     *            navigationNodeLocalizedAttributes {
     *              title
     *            }
     *          }
     *        }
     *      }
     *    }
     * }
     */
    public function resolveData($args): AbstractTransfer
    {
        $navigationClient = $this->getFactory()->getNavigationClient();

        return $navigationClient->findNavigationTreeByKey('MAIN_NAVIGATION', 'de_DE');
    }

}
