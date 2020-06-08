<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\EventListener;


use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class AuthenticationSuccessListener extends AbstractAuthenticationListener
{
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        if ($this->isDisabled()) return;
        $user = $this->getUser($event->getAuthenticationToken());
        $this->lockUserIfLimitReached($user);
        $this->storageProvider->resetFailures($user);
    }
}