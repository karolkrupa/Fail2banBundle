<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\EventListener;


use KarolKrupa\Fail2banBundle\Entity\LockableUser;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;


class AuthenticationFailureListener extends AbstractAuthenticationListener
{
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        if ($this->isDisabled()) return;
        $user = $this->getUser($event->getAuthenticationToken());
        if ($user instanceof LockableUser) {
            $this->lockUserIfLimitReached($user);
            $this->storageProvider->logFailure($user);
        }
    }
}