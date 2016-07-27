<?php

namespace AppBundle\Controller;

use Ddeboer\DataImport\Reader\CsvReader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SplFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/upload", name="upload")
     * @Method("POST")
     */
    public function uploadData(Request $request)
    {
        $fileName = $this->get('app.data_uploader')->upload($request->files->get('file'));
        $file = new SplFileObject($fileName);

        $sql = $this->get('app.converter')->convertFromFile($file);

        return $this->render('default/sql.html.twig', [
            'data' => $sql
        ]);
    }
}
