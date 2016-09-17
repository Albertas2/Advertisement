<?php
namespace AdvertisementBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use AdvertisementBundle\Entity\Advert;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    use ContainerAwareTrait;
    public function load(ObjectManager $manager)
    {
        $advert1 = new Advert();

        $advert1->setUser($this->getReference('User1'));
        $advert1->setTitle('Test Advert Title');
        $advert1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In non lectus tortor. Nulla facilisis dolor ut massa mollis rutrum. Ut lacinia leo enim, vel cursus nulla efficitur eu. Aliquam felis risus, facilisis sit amet posuere sed, posuere et metus. Ut eget elit pellentesque, porttitor turpis et, lacinia elit. Morbi diam.');
        $advert1->setPostingDate(new \DateTime());

        $manager->persist($advert1);
        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}