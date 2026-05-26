<?php
namespace App\Event;

use App\Entity\UserRegisterToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AuthenticationMailerSubscriber
 * @package App\Event
 */
class AuthenticationMailerSubscriber implements EventSubscriberInterface
{

    private MailerInterface $mailer;

    private TranslatorInterface $translator;

    private UrlGeneratorInterface $urlGenerator;

    private string $sender;

    public function __construct(
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator,
        string $sender
    ) {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
        $this->sender = $sender;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() :array
    {
        return [
            Events::USER_PASSWORD_REQUESTED         => 'onUserPasswordRequested',
            Events::USER_PASSWORD_SENT              => 'onUserPasswordSent',
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserPasswordRequested(GenericEvent $event) :void
    {
        /** @var UserRegisterToken $userRegisterToken*/
        $userRegisterToken = $event->getSubject();

        if (!empty($userRegisterToken->getExpiredAt())) {
            $date_expiration = $userRegisterToken->getExpiredAt()->format('d/m/Y');
            $hour_expiration = $userRegisterToken->getExpiredAt()->format('H:i');
        } else {
            $date_expiration = '';
            $hour_expiration = '';
        }

        $linkToActivateUser = $this->urlGenerator->generate('security_authentication_password_define', [
            'key' => $userRegisterToken->getToken()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $subject = $this->translator->trans('user_request_password.subject', [], 'mail');
        $body = $this->translator->trans(
            'user_request_password.description',
            [
                '%login%'               => $userRegisterToken->getUser()->getUsername(),
                '%link%'                => $linkToActivateUser,
                '%date_expiration%'     => $date_expiration,
                '%hour_expiration%'     => $hour_expiration,
            ],
            'mail'
        );

        $message = (new Email())
            ->subject($subject)
            ->to($userRegisterToken->getUser()->getEmail())
            ->from($this->sender)
            ->html($body);

        $this->mailer->send($message);
    }

    /**
     * @param GenericEvent $event
     */
    public function onUserPasswordSent(GenericEvent $event) :void
    {
        /** @var UserRegisterToken $userRegisterToken*/
        $userRegisterToken = $event->getSubject();

        $subject = $this->translator->trans('password_new.subject', [], 'mail');
        $body = $this->translator->trans(
            'password_new.description',
            [
                '%login%'       => $userRegisterToken->getUser()->getUsername(),
                '%password%'    => $userRegisterToken->getUser()->getPlainPassword(),
            ],
            'mail'
        );

        $message = (new Email())
            ->subject($subject)
            ->to($userRegisterToken->getUser()->getEmail())
            ->from($this->sender)
            ->html($body);

        $this->mailer->send($message);
    }
}
