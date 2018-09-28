<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder;

class DefinitionNormalizer implements DefinitionNormalizerInterface
{
    const KEY_BUNDLE = 'bundle';
    const KEY_CONTAINING_BUNDLE = 'containing bundle';
    const KEY_NAME = 'name';
    const KEY_PROPERTY = 'property';
    const KEY_BUNDLES = 'bundles';
    const KEY_DEPRECATED = 'deprecated';

    public function normalizeDefinitions(array $transferDefinitions): array
    {
        $normalizedDefinitions = [];
        foreach ($transferDefinitions as $transferDefinition) {
            $normalizedDefinition = [
                self::KEY_BUNDLE => $transferDefinition[self::KEY_BUNDLE],
                self::KEY_CONTAINING_BUNDLE => $transferDefinition[self::KEY_CONTAINING_BUNDLE],
                self::KEY_NAME => $transferDefinition[self::KEY_NAME],
                self::KEY_DEPRECATED => isset($transferDefinition[self::KEY_DEPRECATED]) ? $transferDefinition[self::KEY_DEPRECATED] : null,
                self::KEY_PROPERTY => $this->normalizeAttributes($transferDefinition[self::KEY_PROPERTY], $transferDefinition[self::KEY_BUNDLE]),
            ];

            $normalizedDefinitions[] = $normalizedDefinition;
        }

        return $normalizedDefinitions;
    }

    /**
     * @param array $attributes
     * @param string $bundle
     *
     * @return array
     */
    protected function normalizeAttributes(array $attributes, $bundle)
    {
        if (isset($attributes[0])) {
            return $this->addBundleToAttributes($attributes, $bundle);
        }

        return $this->addBundleToAttributes([$attributes], $bundle);
    }

    /**
     * @param array $attributes
     * @param string $bundle
     *
     * @return array
     */
    protected function addBundleToAttributes(array $attributes, $bundle)
    {
        foreach ($attributes as &$attribute) {
            $attribute[self::KEY_BUNDLES] = [$bundle];
        }

        return $attributes;
    }
}
