<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\EventListener;


use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationSuccessListener extends AbstractAuthenticationListener
{
    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        if ($this->isDisabled()) return;
        $user = $this->getUser($event->getAuthenticationToken());
        if(!$user) return;
        $this->lockUserIfLimitReached($user);
        $this->storageProvider->resetFailures($user);
    }
}