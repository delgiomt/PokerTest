<?php
// src/Controller/testController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class testController extends AbstractController
{
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('test/number.html.twig',['number' => $number]);
    }
   
    public function uploadAction()
    {
        // ...

        if ($form->isValid()) {

            // instead of saving the file to the server
            // $someNewFilename = ...
            // $form['attachment']->getData()->move($dir, $someNewFilename);

            // you just read the file contents as a string
            $file = $form['attachment']->getData();
            $extension = $file->guessExtension();
            if ($extension == "txt") { // check if the file extension is as required; you can also check the mime type itself: $file->getMimeType()
            $contents = file_get_contents($file->getPathname());
            // do something with the file contents, e.g. store it to the database
            // ...
            }

        // ...
        }
        // ...
    }
}