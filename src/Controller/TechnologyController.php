<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologyController extends AbstractController
{
    #[Route('/technology', name: 'app_technology')]
    public function index(TechnologyRepository $technologyRepository): Response
    {
        $technologies = $technologyRepository->findAll();

        // dd($technologies);

        return $this->render('technology/index.html.twig', [
            'technologies' => $technologies,
        ]);
    }
}
