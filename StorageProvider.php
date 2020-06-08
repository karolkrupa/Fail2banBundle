<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle;


use \Symfony\Component\Security\Core\User\UserInterface;

interface StorageProvider
{
    public function logFailure(UserInterface $user);

    public function resetFailures(UserInterface $user);

    public function getFailuresCount(UserInterface $user, \DateTime $from): int;
}