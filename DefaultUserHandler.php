<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle;


use Doctrine\ORM\EntityManagerInterface;
use KarolKrupa\Fail2banBundle\Entity\LockableUser;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultUserHandler implements UserHandler
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function lock(UserInterface $user)
    {
        if ($user instanceof LockableUser) {
            $user->lock();
            $this->em->flush();
        }
    }

    public function unlock(UserInterface $user)
    {
        if ($user instanceof LockableUser) {
            $user->unlock();
            $this->em->flush();
        }
    }

    public function isLocked(UserInterface $user): bool
    {
        if ($user instanceof LockableUser) {
            return $user->isLocked();
        }

        return false;
    }
}