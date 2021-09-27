<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($form, string $fieldName)
    {
        $imgFile = $form->get($fieldName)->getData();

        if ($imgFile)
        {
            $originalFileName = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFileName = $this->slugger->slug($originalFileName);

            $newFileName = $safeFileName . '-' . uniqid() . '.' . $imgFile->guessExtension();

            try {
                $imgFile->move('uploads', $newFileName);

                return $newFileName;
            } catch (FileException $e) 
            {

            }

            return false;
        }
    }
}

