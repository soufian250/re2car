<?php

namespace DataFixtures;



use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserDataFixtures extends AbstractFixture implements ORMFixtureInterface, ContainerAwareInterface , OrderedFixtureInterface {


    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    private function loadType(ObjectManager $manager, $name) {

        $type = new \ProjectBundle\Entity\Type();

        $type->setName($name);

        $manager->persist($type);
        $manager->flush();

        return $type;
    }

    public function load(ObjectManager $manager )
    {

        $user = new \UserBundle\Entity\User();

        $password = 'soufian';

        $user->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));


        $user->setUsername('soufian');
        $user->setEmail('soufian@gmail.com');

        $manager->persist($user);
        $manager->flush();

        $this->loadType($manager,'coupés');
        $this->loadType($manager,'berlines');
        $this->loadType($manager,'hayons');
        $this->loadType($manager,'break');
        $this->loadType($manager,'limousines');
        $this->loadType($manager,'crossovers');
        $this->loadType($manager,'cabriolets');
        $this->loadType($manager,'minibus');
        $this->loadType($manager,'roadsters');
        $this->loadType($manager,'targa');


    }

    public function getOrder()
    {
        return 1;
    }
}