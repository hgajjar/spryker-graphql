<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

use Symfony\Component\Finder\Finder;

class SchemaTypeDefinitionFinder implements FinderInterface
{
    /**
     * @deprecated Will be removed with next major release
     */
    const KEY_BUNDLE = 'bundle';

    /**
     * @deprecated Will be removed with next major release
     */
    const KEY_CONTAINING_BUNDLE = 'containing bundle';

    /**
     * @deprecated Will be removed with next major release
     */
    const KEY_TRANSFER = 'transfer';

    /**
     * @deprecated Will be removed with next major release
     */
    const TRANSFER_SCHEMA_SUFFIX = '.transfer.xml';

    /**
     * @var array
     */
    protected $sourceDirectories;

    /**
     * @var string
     */
    protected $fileNamePattern;

    /**
     * @param array $sourceDirectories
     * @param string $fileNamePattern
     */
    public function __construct(array $sourceDirectories, $fileNamePattern = '*.transfer.xml')
    {
        $this->sourceDirectories = $sourceDirectories;
        $this->fileNamePattern = $fileNamePattern;
    }

    /**
     * @return \Symfony\Component\Finder\Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    public function getXmlTransferDefinitionFiles()
    {
        $finder = new Finder();

        $existingSourceDirectories = $this->getExistingSourceDirectories();
        if (empty($existingSourceDirectories)) {
            return [];
        }

        $finder->in($existingSourceDirectories)->name($this->fileNamePattern)->depth('< 1');

        return $finder;
    }

    /**
     * @return string[]
     */
    protected function getExistingSourceDirectories()
    {
        return array_filter($this->sourceDirectories, function ($directory) {
            return (bool)glob($directory, GLOB_ONLYDIR);
        });
    }
}
