<?php
namespace App\Controller\Back;

use App\Entity\File;
use App\Form\ProfileType;
use App\Service\FileManager;
use App\Service\ProfileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     *     methods={"GET", "POST"}
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
     * @Route(
     *      "/upload",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param FileManager $fileManager
     * @param TranslatorInterface $translator
     * @param Profiler $profiler
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function upload(
        Request $request,
        FileManager $fileManager,
        TranslatorInterface $translator,
        ?Profiler $profiler
    ) :JsonResponse {
        if (null !== $profiler) {
            $profiler->disable();
        }
        if (!$fileManager->checkType(
            $request->headers->get('x-file-type'),
            [
                    'image/png',
                    'image/jpeg',
                    'image/gif'
                ]
        )) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translator->trans('message.upload.error_type', ['%allowedTypes%' => 'jpeg, png, gif'])
                ],
                200,
                [
                  //  'responseType', 'text/plain'
                ]
            );
        }

        if (!$fileManager->checkSize(
            $request->headers->get('x-file-size'),
            2000000
        )) {
            return $this->json(
                [
                    'success' => false,
                    'message' => $translator->trans('message.upload.error_size', ['%allowedSize%' => '2Mo'])
                ],
                200
            );
        }

        $uploadedFile = $request->files->get('image');
        if (!is_null($uploadedFile)) {
            $file = new File();
            $file->setFile($uploadedFile);
            $fileName = $fileManager->upload($file);
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
