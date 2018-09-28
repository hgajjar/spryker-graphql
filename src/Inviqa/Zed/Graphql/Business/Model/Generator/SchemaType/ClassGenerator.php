<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\SchemaType;

use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionBuilder\ClassDefinitionInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\DefinitionInterface;
use Inviqa\Zed\Graphql\Business\Model\Generator\GeneratorInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class ClassGenerator implements GeneratorInterface
{
    const TWIG_TEMPLATES_LOCATION = '/Templates/';

    /**
     * @var string
     */
    protected $targetDirectory;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;

        $loader = new Twig_Loader_Filesystem(__DIR__ . self::TWIG_TEMPLATES_LOCATION);
        $this->twig = new Twig_Environment($loader, []);
    }

    public function generate(DefinitionInterface $definition): string
    {
        $twigData = $this->getTwigData($definition);
        $fileName = $definition->getName() . '.php';
        $fileContent = $this->twig->render('class.php.twig', $twigData);

        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        file_put_contents($this->targetDirectory . $fileName, $fileContent);

        return $fileName;
    }

    /**
     * @param ClassDefinitionInterface|DefinitionInterface $classDefinition
     *
     * @return array
     */
    public function getTwigData(DefinitionInterface $classDefinition): array
    {
        return [
            'className' => $classDefinition->getName(),
            'constructorDefinition' => $classDefinition->getConstructorDefinition(),
        ];
    }
}
