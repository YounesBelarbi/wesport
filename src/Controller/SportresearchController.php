<?php

namespace App\Controller;

use App\Form\SportResearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SportresearchController extends AbstractController
{
    /**
     * @Route("/sportresearch", name="sportresearch")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(SportResearchType::class);

        $form->handleRequest($request);

        if($request->isXmlHttpRequest()){
            
        }


        return $this->render('sportresearch/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
