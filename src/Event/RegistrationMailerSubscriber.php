<?php
namespace App\Event;

use App\Entity\User;
use App\Entity\UserRegisterToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationMailerSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var string
     */
    private $sender;

    /**
     * RegistrationMailerSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param UrlGeneratorInterface $urlGenerator
     * @param TranslatorInterface $translator
     * @param $sender
     */
    public function __construct(
        \Swift_Mailer $mailer,
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator,
        $sender
    ) {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
        $this->sender = $sender;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::USER_CREATED                    => 'onUserCreated',
            Events::USER_CONFIRMED                  => 'onUserConfirmed',
            Events::USER_ACCOUNT_TOKEN_REQUESTED    => 'onUserRequestedAccountToken',
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserCreated(GenericEvent $event) :void
    {
        //** @var UserRegisterToken $userRegisterToken*/
        $userRegisterToken = $event->getSubject();

        $linkToActivateUser = $this->urlGenerator->generate('security_registration_activation', [
            'key' => $userRegisterToken->getToken()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $subject = $this->translator->trans('user_created.subject', [], 'mail');
        $body = $this->translator->trans(
            'user_created.description',
            [
            '%login%'       => $userRegisterToken->getUser()->getUsername(),
            '%password%'    => $userRegisterToken->getUser()->getPlainPassword(),
            '%link%'        => $linkToActivateUser
            ],
            'mail'
        );

        $message = ( new \Swift_Message())
            ->setSubject($subject)
            ->setTo($userRegisterToken->getUser()->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserConfirmed(GenericEvent $event) :void
    {
        /** @var User $user */
        $user = $event->getSubject();

        $subject = $this->translator->trans('user_confirmed.subject', [], 'mail');
        $body = $this->translator->trans(
            'user_confirmed.description',
            [
                '%login%'       => $user->getUsername(),
            ],
            'mail'
        );

        $message = ( new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserRequestedAccountToken(GenericEvent $event) :void
    {
        /** @var UserRegisterToken $userRegisterToken*/
        $userRegisterToken = $event->getSubject();

        $linkToActivateUser = $this->urlGenerator->generate('security_registration_activation', [
            'key' => $userRegisterToken->getToken()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $subject = $this->translator->trans('user_request_account_token.subject', [], 'mail');
        $body = $this->translator->trans(
            'user_request_account_token.description',
            [
                '%login%'       => $userRegisterToken->getUser()->getUsername(),
                '%link%'        => $linkToActivateUser
            ],
            'mail'
        );

        $message = ( new \Swift_Message())
            ->setSubject($subject)
            ->setTo($userRegisterToken->getUser()->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
