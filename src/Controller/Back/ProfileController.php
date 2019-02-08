<?php
namespace App\Controller\Back;

use App\Form\ProfileType;
use App\Service\ProfileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileManager;
use App\Entity\File;

/**
 * Class ProfileController
 * @package App\Controller\Back
 */
class ProfileController extends AbstractController
{

    /**
     * @Route(
     *     "/profile",
     *     name="back_profile",
     *     methods={"GET", "POSET"}
     * )
     * @Security("is_granted('ROLE_USER')")
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

            return $this->redirectToRoute('back_profile');
        }

        return $this->render('back/profile.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/upload")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function upload(Request $request)
    {
        $uploadedFile = $request->files->get('image');
        if (!is_null($uploadedFile)) {
            $file = new File();
            $file->setFile($uploadedFile);
            $fileName = $this->get(FileManager::class)->upload($file);

            $file->setName($fileName);
            $file->setPath('uploads' . DIRECTORY_SEPARATOR . $fileName);
            return $this->json([
                'success' => true,
                'name' => $file->getName(),
                'path' => $file->getPath(),
            ]);
        }

        return $this->json([
            'success' => false,
        ]);
    }
}
