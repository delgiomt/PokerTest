<?php
// src/Controller/testController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class loadController extends AbstractController
{
    
   /**
   * Require ROLE_USER
   *
   * @IsGranted("ROLE_USER")
   */
     public function index()
    {
        return $this->render('loadfile/loadfile.html.twig');
    }
       
}