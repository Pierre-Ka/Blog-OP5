<?php

namespace BlogApp\Entity;

abstract class Entity
{
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function resizeImageWithCrop($fullNameSource, $fullNameDestination, $w, $h, $crop = TRUE)
    {
        list($width, $height) = getimagesize($fullNameSource);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        $source = imagecreatefromjpeg($fullNameSource);
        $destination = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($destination, $fullNameDestination);
        imagedestroy($destination);
    }

    public function resizeImage($fullNameSource, $fullNameDestination, $width, $height)
    {
        $source = imagecreatefromjpeg($fullNameSource);
        $destination = imagecreatetruecolor($width, $height);

        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

        imagejpeg($destination, $fullNameDestination);
        imagedestroy($destination);
    }
}
