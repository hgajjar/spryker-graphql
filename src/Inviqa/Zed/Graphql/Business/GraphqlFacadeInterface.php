<?php

namespace Inviqa\Zed\Graphql\Business;

use Psr\Log\LoggerInterface;

interface GraphqlFacadeInterface
{

    public function generateSchemaTypes(LoggerInterface $messenger): void;

}
