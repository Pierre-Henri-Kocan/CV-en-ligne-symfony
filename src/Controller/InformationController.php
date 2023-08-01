<?php

namespace App\Controller;

use App\Repository\InformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    #[Route('/information', name: 'app_information')]
    public function index(InformationRepository $informationRepository): Response
    {

        $informations = $informationRepository->findAll();
        // dd($informations);

        return $this->render('information/index.html.twig', [
            'informations' => $informations,
        ]);
    }
}
