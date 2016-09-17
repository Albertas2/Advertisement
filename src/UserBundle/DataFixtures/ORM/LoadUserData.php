<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use UserBundle\Entity\User;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    
    use ContainerAwareTrait;
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user1 = $userManager->createUser();
        $user1->setUsername('User1');
        $user1->setEmail('user1@mail.com');
        $user1->setPlainPassword('Password1');
        $user1->setEnabled(true);
        $user1->setRoles(['ROLE_USER']);
        
        $this->addReference('User1', $user1);
        
        $userManager->updateUser($user1, true);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}