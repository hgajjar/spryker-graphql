<?php

namespace Inviqa\Zed\Graphql\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Inviqa\Zed\Graphql\Business\GraphqlFacade getFacade()
 */
class GraphqlConsole extends Console
{

    const COMMAND_NAME = 'graphql:types:generate';
    const DESCRIPTION = 'Generate graphql types using .transfer.xml files';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messenger = $this->getMessenger();

        $this->getFacade()->generateSchemaTypes($messenger);

        return static::CODE_SUCCESS;
    }

}
