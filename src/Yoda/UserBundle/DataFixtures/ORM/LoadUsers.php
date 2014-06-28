<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 6/27/14
 * Time: 3:33 PM
 */

namespace Yoda\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function Load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->encodePassword($user, 'user'));
        $user->setEmail('user@user.com');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->encodePassword($admin, 'admin'));
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $manager->flush();
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


} 