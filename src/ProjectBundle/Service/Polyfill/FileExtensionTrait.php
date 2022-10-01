<?php

namespace ProjectBundle\Service\Polyfill;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileExtensionTrait
{
    /**
     * Guess the extension of the given file.
     */
    private function getExtension(UploadedFile $file)
    {
        $originalName = $file->getClientOriginalName();

        if ('' !== ($extension = \pathinfo($originalName, \PATHINFO_EXTENSION))) {
            return $extension;
        }

        if ('' !== ($extension = $file->guessExtension())) {
            return $extension;
        }

        return null;
    }
}