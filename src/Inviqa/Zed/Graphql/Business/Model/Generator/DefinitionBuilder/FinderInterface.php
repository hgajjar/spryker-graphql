<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

interface FinderInterface
{
    /**
     * @return \Symfony\Component\Finder\Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    public function getXmlTransferDefinitionFiles();
}
