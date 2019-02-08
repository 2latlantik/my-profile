<?php
namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use App\Form\LoginForm;

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
}
