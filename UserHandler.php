<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle;


use \Symfony\Component\Security\Core\User\UserInterface;

interface UserHandler
{
    public function lock(UserInterface $user);

    public function isLocked(UserInterface $user): bool;

    public function getLockDate(UserInterface $user): \DateTimeInterface;

    public function unlock(UserInterface $user);
}