<?php
namespace App\Controller\Security;

use App\Annotation\TokenableManager;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\UserRegisterToken;

class RegistrationController extends Controller
{

    /**
     * @Route(
     *     "/register",
     *     name="security_registration_register"
     * )
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EventDispatcherInterface $dispatcher
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EventDispatcherInterface $dispatcher
    ) : Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $token = new UserRegisterToken();
            $token->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($token);
            $em->flush();

            $event = new GenericEvent($token);
            $dispatcher->dispatch('user.created', $event);
            $this->addFlash('success', 'success.user.registered');

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route(
     *     "/user-activate/{key}",
     *     name="security_registration_activation"
     * )
     * @Method({"GET"})
     * @ParamConverter("token", options={"mapping": {"key": "token"}})
     * @param UserRegisterToken $token
     * @param TokenableManager $tokenManager
     * @param EventDispatcherInterface $dispatcher
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function activation(
        UserRegisterToken $token,
        TokenableManager $tokenManager,
        EventDispatcherInterface $dispatcher
    ) :Response {
        /** @var User $user */
        $user = $token->getUser();

        if ($user->getIsActive()) {
            $this->addFlash('warning', 'warning.user.account_let_confirmed');
            return $this->redirectToRoute('homepage');
        }

        if ($tokenManager->getState($token) == 'expired') {
            return $this->render('security/request_account_token.html.twig', [
                'user'  => $user
            ]);
        } elseif ($tokenManager->getState($token) == 'valid') {
            $user->setIsActive(true);

            $event = new GenericEvent($user);
            $dispatcher->dispatch('user.account_confirmed', $event);

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'success.user.account_confirmed');

            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route(
     *      "/user-activate/new/{key}",
     *      name="security_registration_token"
     * )
     * @Method({"GET"})
     * @ParamConverter("token", options={"mapping": {"key": "token"}})
     * @param UserRegisterToken $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function token(UserRegisterToken $token) :Response
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

        $event = new GenericEvent($newToken);
        $this->get('event_dispatcher')->dispatch('user.account_token_requested', $event);
        $this->addFlash('success', 'success.user.account_token_sent');

        return $this->redirectToRoute('homepage');
    }
}
