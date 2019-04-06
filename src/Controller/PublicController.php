<?php
namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublicController
 * @package App\Controller
 */
class PublicController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="homepage"
     * )
     * @return Response
     */
    public function index(): Response
    {
        $profiles = $this->getDoctrine()->getRepository(Profile::class)->getRandomEntities();

        return $this->render('public/index.html.twig', [
            'profiles' => $profiles
        ]);
    }

    /**
     * @Route(
     *     "/mp/{slug}",
     *     name="one_profile"
     * )
     * @param Profile $profile
     * @return Response
     */
    public function oneProfile(Profile $profile): Response
    {
        return $this->render('public/profile.html.twig', [
            'profile' => $profile
        ]);
    }
}
