<?php
namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $profiles = $this->getDoctrine()->getRepository(Profile::class)->getRandomEntities();

        return $this->render('public/index.html.twig', [
            'profiles' => $profiles
        ]);
    }

    #[Route('/mp/{slug}', name: 'one_profile')]
    public function oneProfile(string $slug): Response
    {
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(['slug' => $slug]);
        if ($profile === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('public/profile.html.twig', [
            'profile' => $profile
        ]);
    }
}
