<?php


namespace AppBundle\Repository;


use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends \Doctrine\ORM\EntityRepository implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        $user = $this->findBy( ['token' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException('No user found for username '.$username);
        }
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}