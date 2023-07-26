<?php

namespace App\Controller;

use App\Repository\DetailRepository;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceController extends AbstractController
{
    #[Route('/experience', name: 'app_experience')]
    public function index(ExperienceRepository $experienceRepository): Response
    {
        $experiences = $experienceRepository->findAll();
        //dd($experiences);

        return $this->render('experience/index.html.twig', [
            'experiences' => $experiences,
        ]);
    }
}
