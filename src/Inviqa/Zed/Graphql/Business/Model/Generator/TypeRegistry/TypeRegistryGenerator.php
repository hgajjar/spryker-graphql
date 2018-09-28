<?php

namespace Inviqa\Zed\Graphql\Business\Model\Generator\TypeRegistry;

class TypeRegistryGenerator implements TypeRegistryGeneratorInterface
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

        $loader = new \Twig_Loader_Filesystem(__DIR__ . self::TWIG_TEMPLATES_LOCATION);
        $this->twig = new \Twig_Environment($loader, []);
    }

    public function generate(array $definitions): string
    {
        $types = [];
        foreach ($definitions as $definition) {
            $types[] = $definition->getName();
        }
        $types = array_unique($types);

        $fileName = 'TypeRegistry.php';
        $fileContent = $this->twig->render('type_registry.php.twig', ['types' => $types]);

        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        file_put_contents($this->targetDirectory . $fileName, $fileContent);

        return $fileName;
    }

}
