<?php


namespace App\Service;


use Symfony\Component\Security\Core\Security;

class UserRole
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getUserRole()
    {
        $user = $this->security->getUser();
        if ($user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return 'ADMIN';
            } else {
                return 'MARQUE';
            }
        }
        return 'USER';
    }
}