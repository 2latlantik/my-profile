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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route(
     *      "login",
     *      name="login"
     * )
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils) :Response
    {
        $form = $this->createForm(LoginForm::class);

        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        if (null === $request->get('_route')) {
            $pathRender = 'security/partials/_login.html.twig';
        } else {
            $pathRender = 'security/login.html.twig';
        }

        return $this->render($pathRender, array(
            'form'  => $form->createView(),
            'path' => 'login',
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route(
     *      "change-password",
     *      name="change_password"
     * )
     * @Security("is_granted('ROLE_USER')")
     * @param Request $request
     * @param TokenStorageInterface $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function changePassword(
        Request $request,
        TokenStorageInterface $token,
        UserPasswordEncoderInterface $passwordEncoder,
        TranslatorInterface $translator
    ) :Response {
        $user = $token->getToken()->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $request->request->get('change_password')['oldPassword'];

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('success', 'success.user.password_changed');

                return $this->redirectToRoute('homepage');
            } else {
                $form->addError(new FormError($translator->trans('message.error.bad_old_password')));
            }
        }

        return $this->render('security/password_change.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
