<?php
namespace App\Controller\Security;

use App\Annotation\TokenableManager;
use App\Entity\User;
use App\Entity\UserRegisterToken;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration_register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EventDispatcherInterface $dispatcher
    ): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ✔️ Nouveau hasher moderne
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);

            $token = new UserRegisterToken();
            $token->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($token);
            $em->flush();

            // ✔️ dispatch dans le bon ordre
            $event = new GenericEvent($token);
            $dispatcher->dispatch($event, 'user.created');

            $this->addFlash('success', 'success.user.registered');
            return $this->redirectToRoute('homepage');
        }

        $response = new Response();

        $policy = "default-src http://* 'self' https://www.google.com/ https://www.gstatic.com/"
            ."https://www.googletagmanager.com/ 'unsafe-inline' 'unsafe-eval';"
            ."script-src 'self' https://www.google.com/ https://www.gstatic.com/ "
            ."https://www.googletagmanager.com/ 'unsafe-inline' 'unsafe-eval';"
            ."frame-src 'self' https://www.google.com/recaptcha/ ;"
            ."style-src 'self' https://www.google.com/recaptcha/;";

        $response->headers->set("Content-Security-Policy", $policy);
        $response->headers->set("X-Content-Security-Policy", $policy);
        $response->headers->set("X-WebKit-CSP", $policy);

        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()],
            $response
        );
    }

    /**
     * @Route("/user-activate/{key}", name="security_registration_activation")
     * @ParamConverter("token", options={"mapping": {"key": "token"}})
     */
    public function activation(
        UserRegisterToken $token,
        TokenableManager $tokenManager,
        EventDispatcherInterface $dispatcher
    ): Response {
        /** @var User $user */
        $user = $token->getUser();

        if ($user->getIsActive()) {
            $this->addFlash('warning', 'warning.user.account_let_confirmed');
            return $this->redirectToRoute('homepage');
        }

        $state = $tokenManager->getState($token);

        if ($state === 'expired') {
            return $this->render('security/request_account_token.html.twig', [
                'user' => $user
            ]);
        }

        if ($state === 'valid') {
            $user->setIsActive(true);

            $event = new GenericEvent($user);
            $dispatcher->dispatch($event, 'user.account_confirmed');

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'success.user.account_confirmed');

            return $this->redirectToRoute('homepage');
        }

        // ✔️ fallback obligatoire
        $this->addFlash('warning', 'warning.user.token_invalid');
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/user-activate/new/{key}", name="security_registration_token")
     * @ParamConverter("token", options={"mapping": {"key": "token"}})
     */
    public function token(UserRegisterToken $token): Response
    {
        if ($token->getUser()->getIsActive()) {
            $this->addFlash('warning', 'warning.user.account_let_confirmed');
            return $this->redirectToRoute('homepage');
        }

        $newToken = new UserRegisterToken();
        $newToken->setUser($token->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newToken);
        $em->flush();

        // ✔️ plus de $this->get('event_dispatcher') (déprécié)
        $event = new GenericEvent($newToken);
        $this->container->get('event_dispatcher')->dispatch($event, 'user.account_token_requested');

        $this->addFlash('success', 'success.user.account_token_sent');

        return $this->redirectToRoute('homepage');
    }
}
