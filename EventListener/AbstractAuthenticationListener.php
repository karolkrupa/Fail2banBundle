<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\EventListener;


use KarolKrupa\Fail2banBundle\StorageProvider;
use KarolKrupa\Fail2banBundle\UserHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

abstract class AbstractAuthenticationListener
{
    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @var StorageProvider
     */
    protected $storageProvider;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var UserHandler
     */
    protected $userHandler;

    public function __construct(
        UserProviderInterface $userProvider,
        StorageProvider $storageProvider,
        UserHandler $userHandler,
        $config
    )
    {
        $this->userProvider = $userProvider;
        $this->storageProvider = $storageProvider;
        $this->config = $config;
        $this->userHandler = $userHandler;
    }

    protected function getUser(TokenInterface $token): ?UserInterface
    {
        try {
            return $this->userProvider->loadUserByUsername($token->getUsername());
        } catch (UsernameNotFoundException $exception) {
            return null;
        }
    }

    protected function lockUserIfLimitReached(UserInterface $user)
    {
        if ($this->storageProvider->getFailuresCount($user, new \DateTime()) > $this->config['allowed_attempts_count']) {
            $this->userHandler->lock($user);
        }

        $this->denyAccessIfLocked($user);
    }

    protected function denyAccessIfLocked(UserInterface $user)
    {
        if ($this->userHandler->isLocked($user)) {
            throw new HttpException(Response::HTTP_TOO_MANY_REQUESTS);
        }
    }

    protected function isDisabled(): bool
    {
        return !$this->config['enabled'];
    }
}