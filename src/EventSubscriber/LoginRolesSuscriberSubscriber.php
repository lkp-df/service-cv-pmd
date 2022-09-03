<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginRolesSuscriberSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    private $sessionInterface;
    public function __construct(UrlGeneratorInterface $urlGenerator, SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
        $this->urlGenerator = $urlGenerator;
    }
    public function onLoginSuccessEvent(LoginSuccessEvent $event)
    {
        $user  = $event->getUser();
        $choice = $this->sessionInterface->get('choice',[]);
        if(!empty($choice)){
            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('modeles_choice',['id'=>$choice])));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}