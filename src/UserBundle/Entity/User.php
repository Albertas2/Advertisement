<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AdvertisementBundle\Entity\Advertisement;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="AdvertisementBundle\Entity\Advertisement", mappedBy="user")
     */
    private $advertisements;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add advert
     *
     * @param Advertisement $advertisement
     *
     * @return User
     */
    public function addAdvertisement(Advertisement $advertisement)
    {
        $this->advertisements[] = $advertisement;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param Advertisement $advertisement
     */
    public function removeAdvertisement(Advertisement $advertisement)
    {
        $this->advertisements->removeElement($advertisement);
    }

    /**
     * Get adverts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvertisements()
    {
        return $this->advertisements;
    }
}
