<?php

namespace App\Controller;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use App\Service\HandsService;
use Psr\Log\LoggerInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/doUpload", name="upload")
     */
    public function index(Request $request, string $uploadDir, 
    FileUploader $uploader, LoggerInterface $logger, HandsService $handsService)
    {
    $token = $request->get("token");

    if (!$this->isCsrfTokenValid('upload', $token)) 
    {
    $logger->info("CSRF failure");

    return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
        ['content-type' => 'text/plain']);
    }        

    $file = $request->files->get('myfile');

    if (empty($file)) 
    {
    return new Response("No file specified",  
        Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
    }        

    $filename = $file->getClientOriginalName();
    $ret = $uploader->upload($uploadDir, $file, $filename);
    $numberOfHands=$handsService->storeHands($ret);
   

    return new Response("File uploaded and stored to the DB ({$numberOfHands} hands loaded)" ,  Response::HTTP_OK, 
    ['content-type' => 'text/plain']);         
    }
}
