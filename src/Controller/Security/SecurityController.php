<?php
namespace App\Controller\Security;

use App\Form\ChangePasswordType;
use App\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils): Response
    {
        $form = $this->createForm(LoginForm::class);

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $pathRender = $request->get('_route') === null
            ? 'security/partials/_login.html.twig'
            : 'security/login.html.twig';

        return $this->render($pathRender, [
            'form' => $form->createView(),
            'path' => 'login',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("change-password", name="change_password")
     * @Security("is_granted('ROLE_USER')")
     */
    public function changePassword(
        Request $request,
        TokenStorageInterface $token,
        UserPasswordHasherInterface $passwordHasher,
        TranslatorInterface $translator,
        EntityManagerInterface $em
    ): Response {
        $user = $token->getToken()->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPassword = $request->request->get('change_password')['oldPassword'];

            // ✔️ Nouveau validateur moderne
            if ($passwordHasher->isPasswordValid($user, $oldPassword)) {

                // ✔️ Nouveau hasher moderne
                $hashed = $passwordHasher->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($hashed);

                $em->flush();

                $this->addFlash('success', 'success.user.password_changed');
                return $this->redirectToRoute('homepage');

            } else {
                $form->addError(new FormError(
                    $translator->trans('message.error.bad_old_password')
                ));
            }
        }

        return $this->render('security/password_change.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
