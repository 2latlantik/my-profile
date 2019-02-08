<?php
namespace App\Controller\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Annotation\TokenableManager;
use App\Entity\PasswordToken;
use App\Entity\User;

class AuthenticationController extends AbstractController
{

    /**
     * @Route(
     *      "/password-lost",
     *      name="security_authentication_password_request"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function passwordRequest(Request $request) :Response
    {
        $form  = $this->createFormBuilder()
            ->add('mail', EmailType::class, array(
                'label' => 'label.email',

                'constraints'   => new NotBlank(),
                'required'  => true
            ))
            ->add('send', SubmitType::class, array(
                'label' => 'action.password_lost.do',
                'translation_domain'    => 'messages',
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->loadUserByUsername($data['mail']);

            if (null !== $user) {
                $token = new PasswordToken();
                $token->setUser($user);
                $em->persist($token);
                $em->flush();

                $event = new GenericEvent($token);
                $this->get('event_dispatcher')->dispatch('user.password_requested', $event);

                $this->addFlash('success', 'success.user.password_requested_sent');
                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash('warning', 'warning.user.not_recognized');
                return $this->redirectToRoute('security_authentication_password_request');
            }
        }
        return $this->render('security/password_lost.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route(
     *      "/user-password-new/{key}",
     *      name="security_authentication_password_define"
     * )
     * @ParamConverter(
     *      "token",
     *      options={
     *          "mapping": {
     *              "key": "token"
     *          }
     *      }
     * )
     * @param PasswordToken $token
     * @param Request $request
     * @param TokenableManager $tokenManager
     * @param EventDispatcherInterface $dispatcher
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function passwordDefine(
        PasswordToken $token,
        Request $request,
        TokenableManager $tokenManager,
        EventDispatcherInterface $dispatcher,
        UserPasswordEncoderInterface $passwordEncoder
    ) : Response {
        if ($tokenManager->getState($token) == 'expired') {
            $this->addFlash('warning', 'user.password_request_expired');
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createFormBuilder()
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'label.password'),
                'second_options' => array('label' => 'label.password_repeat'),
            ))
            ->add('send', SubmitType::class, array(
                'label' => 'action.password_define.do',
                'translation_domain'    => 'messages'
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $token->getUser();
            $user->setPlainPassword($data['plainPassword']);
            $password = $passwordEncoder->encodePassword($user, $data['plainPassword']);
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $event = new GenericEvent($token);
            $dispatcher->dispatch('user.new_password_sent', $event);

            $this->addFlash('success', 'success.new_password_sent');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/password_new.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
