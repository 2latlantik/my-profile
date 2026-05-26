<?php
namespace App\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Annotation\TokenableManager;
use App\Entity\PasswordToken;
use App\Entity\User;
use App\Repository\PasswordTokenRepository;

class AuthenticationController extends AbstractController
{
    #[Route('/password-lost', name: 'security_authentication_password_request')]
    public function passwordRequest(
        Request $request,
        EventDispatcherInterface $dispatcher
    ): Response {
        $form = $this->createFormBuilder()
            ->add('mail', EmailType::class, [
                'label' => 'label.email',
                'constraints' => new NotBlank(),
                'required' => true,
            ])
            ->add('send', SubmitType::class, [
                'label' => 'action.password_lost.do',
                'translation_domain' => 'messages',
            ])
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

                // ✔️ dispatch dans le bon ordre
                $event = new GenericEvent($token);
                $dispatcher->dispatch($event, 'user.password_requested');

                $this->addFlash('success', 'success.user.password_requested_sent');
                return $this->redirectToRoute('homepage');
            }

            $this->addFlash('warning', 'warning.user.not_recognized');
            return $this->redirectToRoute('security_authentication_password_request');
        }

        return $this->render('security/password_lost.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user-password-new/{key}', name: 'security_authentication_password_define')]
    public function passwordDefine(
        string $key,
        Request $request,
        PasswordTokenRepository $passwordTokenRepository,
        TokenableManager $tokenManager,
        EventDispatcherInterface $dispatcher,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $token = $passwordTokenRepository->findOneBy(['token' => $key]);
        if ($token === null) {
            throw $this->createNotFoundException();
        }

        if ($tokenManager->getState($token) === 'expired') {
            $this->addFlash('warning', 'user.password_request_expired');
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createFormBuilder()
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'label.password'],
                'second_options' => ['label' => 'label.password_repeat'],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'action.password_define.do',
                'translation_domain' => 'messages',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $token->getUser();
            $user->setPlainPassword($data['plainPassword']);

            // ✔️ nouveau hasher moderne
            $hashed = $passwordHasher->hashPassword($user, $data['plainPassword']);
            $user->setPassword($hashed);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            // ✔️ dispatch dans le bon ordre
            $event = new GenericEvent($token);
            $dispatcher->dispatch($event, 'user.new_password_sent');

            $this->addFlash('success', 'success.new_password_sent');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/password_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
