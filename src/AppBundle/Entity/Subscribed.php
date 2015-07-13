<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Subscribed extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="group_token", type="string", length=255, nullable=true)
     */
    private $groupToken;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set groupToken
     *
     * @param string $groupToken
     * @return Subscribed
     */
    public function setGroupToken($groupToken)
    {
        $this->groupToken = $groupToken;

        return $this;
    }

    /**
     * Get groupToken
     *
     * @return string 
     */
    public function getGroupToken()
    {
        return $this->groupToken;
    }
}
