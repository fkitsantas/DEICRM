<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUser extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Autoload user to the database
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('deicrm');
        $plainPassword = '123';
        $encoded = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setEmail('admin@deicrm.app');
        $user->setFirstname('deicrm');
        $user->setLastname('deicrm');
        $user->setMiddlename('deicrm');
        $user->setStatus('active');
        $user->setIntials('Mr');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $manager->flush();
    }
}
