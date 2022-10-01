<?php

namespace ProjectBundle\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Container;


class FileUploader
{

    protected $container;

    public function __construct(Container $container,$targetDirectory) {
        $this->container = $container;
    }

    public function upload(UploadedFile $imageName)
    {
        $originalFilename = pathinfo($imageName->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        // $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);

        $newFilename = $originalFilename.'-'.uniqid().'.'.$imageName->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $imageName->move($this->getTargetDirectory(), $newFilename);
        } catch (FileException $e) {
            // Handle Exceptions here
        }

        return $newFilename;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}