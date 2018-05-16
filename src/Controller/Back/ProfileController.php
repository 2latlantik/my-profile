<?php
namespace App\Controller\Back;

use App\Form\ProfileType;
use App\Service\ProfileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @package App\Controller\Back
 */
class ProfileController extends Controller
{

    /**
     * @Route("/profile", name="back_profile")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @param ProfileManager $profileManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilePage(Request $request, ProfileManager $profileManager) :Response
    {
        $profile = $profileManager->getProfile();

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();

            $this->addFlash('success', 'success.profile.updated');
        }

        return $this->render('back/profile.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
