<?php
// src/Controller/testController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class loadController extends AbstractController
{
    
    /**
     * @Route("/load")
     */
    public function index()
    {
        return $this->render('loadfile/loadfile.html.twig');
    }
   
    public function uploadAction()
    {
        /*if ($form->isValid()) {

            $file = $form['attachment']->getData();
            $extension = $file->guessExtension();
            if ($extension == "txt") { 
            $contents = file_get_contents($file->getPathname());
            }
        }
        */
    }
}