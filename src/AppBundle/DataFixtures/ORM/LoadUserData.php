<?php

/*
 * This file is part of the SymfonyIdSkeleton package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
final class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userPassword = 'siab';
        $date = new \DateTime();

        $user = new User();
        $user->setUsername($userPassword);
        $user->setEmail('admin@mail.com');
        $user->setFullName('super administrator');
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setPlainPassword($userPassword);
        $user->setEnabled(true);
        $user->setCreatedAt($date);
        $user->setUpdatedAt($date);
        $user->setCreatedBy('SYSTEM');
        $user->setUpdatedBy('SYSTEM');

        $manager->persist($user);
        $manager->flush();
    }
}
