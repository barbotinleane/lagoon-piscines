<?php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;
    private $filesystem;

    public function __construct($targetDirectory, SluggerInterface $slugger, Filesystem $filesystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file, string $targetDirectory): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory().$targetDirectory, $fileName);
        } catch (FileException $e) {
            // error
        }

        return $fileName;
    }

    public function delete(string $imageName, string $targetDirectory): string
    {
        $fileDirectory = $this->getTargetDirectory().$targetDirectory;

        try {
            $this->filesystem->mkdir($fileDirectory);
            if($this->filesystem->exists($fileDirectory.'/'.$imageName)) {
                $this->filesystem->remove($fileDirectory.'/'.$imageName);
            }
            return true;
        } catch (FileException $e) {
            // error
            return false;
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}