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

    /**
     * @var string
     *
     * @ORM\Column(name="friendemail", type="string", length=255, nullable=true)
     */
    private $friendemail;

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

    /**
     * Set friendemail
     *
     * @param string $friendemail
     * @return Subscribed
     */
    public function setFriendemail($friendemail)
    {
        $this->friendemail = $friendemail;

        return $this;
    }

    /**
     * Get friendemail
     *
     * @return string 
     */
    public function getFriendemail()
    {
        return $this->friendemail;
    }
}
