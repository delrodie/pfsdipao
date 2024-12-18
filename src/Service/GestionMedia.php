<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GestionMedia
{
    private $mediaProfile;
    private $mediaCV;
    public function __construct(
        $profileDirectory, $cvDirectory,
    )
    {
        $this->mediaProfile = $profileDirectory;
        $this->mediaCV = $cvDirectory;
    }

    /**
     * @param $form
     * @param object $entity
     * @param string $entityName
     * @return void
     */
    public function media($form, object $entity, string $entityName): void
    {
        // Gestion des médias
        $mediaFile = $form->get('media')->getData();
        if ($mediaFile){
            $media = $this->upload($mediaFile, $entityName);

            if ($entity->getMedia()){
                $this->removeUpload($entity->getMedia(), $entityName);
            }

            $entity->setMedia($media);
        }
    }

    /**
     * @param UploadedFile $file
     * @param $media
     * @return string
     */
    public function upload(UploadedFile $file, $media = null): string
    {
        // Initialisation du slug
        $slugify = new AsciiSlugger();

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugify->slug(strtolower($originalFileName));
        $newFilename = $safeFilename.'-'.Time().'.'.$file->guessExtension();

        // Deplacement du fichier dans le repertoire dedié
        try { //dd($media);
            if ($media === 'profile') $file->move($this->mediaProfile, $newFilename);
            elseif ($media === 'cv') $file->move($this->mediaCV, $newFilename);
            else $file->move($this->mediaProfile, $newFilename);
        }catch (FileException $e){

        }

        return $newFilename;
    }

    /**
     * Suppression de l'ancien media sur le server
     *
     * @param $ancienMedia
     * @param null $media
     * @return bool
     */
    public function removeUpload($ancienMedia, $media = null): bool
    {
        if ($media === 'profile') unlink($this->mediaProfile.'/'.$ancienMedia);
        elseif ($media === 'cv') unlink($this->mediaCV.'/'.$ancienMedia);
        else return false;

        return true;
    }
}