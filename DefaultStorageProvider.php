<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle;


use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultStorageProvider implements StorageProvider
{
    const CACHE_KEY = 'fail2ban_storage';
    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * @var mixed
     */
    private $storage;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();

        $this->storage = $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) {
            return [];
        });
    }

    public function logFailure(UserInterface $user)
    {
        $this->incrementUserCount($user);
        $this->save();
    }

    public function resetFailures(UserInterface $user)
    {
        $this->setUserCount($user, 0);
        $this->save();
    }

    public function getFailuresCount(UserInterface $user, \DateTime $from): int
    {
        return $this->getUserCount($user);
    }

    private function setUserCount(UserInterface $user, $count)
    {
        $this->storage[$user->getId()] = $count;
    }

    private function incrementUserCount(UserInterface $user)
    {
        $count = $this->getUserCount($user);

        $count += 1;

        $this->setUserCount($user, $count);
    }

    private function getUserCount(UserInterface $user): int
    {
        if (isset($this->storage[$user->getId()])) {
            return $this->storage[$user->getId()];
        }
        return 0;
    }

    private function save()
    {
        /** @var CacheItemInterface $item */
        $item = $this->cache->getItem(self::CACHE_KEY);

        $item->set($this->storage);
        $this->cache->save($item);
    }
}