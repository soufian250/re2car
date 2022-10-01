<?php

namespace ProjectBundle\Service;


use ProjectBundle\Service\Polyfill;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;


class UniqidNamer  implements NamerInterface
{
    use Polyfill\FileExtensionTrait;

    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $name = \str_replace('.', '', \uniqid('', true));
        $extension = $this->getExtension($file);

        if (\is_string($extension) && '' !== $extension) {
            $name = \sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }
}