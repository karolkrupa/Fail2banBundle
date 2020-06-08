<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle\Entity;


interface LockableUser
{
    public function lock();

    public function unlock();

    public function isLocked(): bool;

    public function setLockedAt(?\DateTimeInterface $dateTime);

    public function getLockedAt(): ?\DateTimeInterface;
}