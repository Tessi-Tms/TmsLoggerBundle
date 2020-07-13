<?php

/**
 * @author Nathalie De Sousa <nathalie.de.sousa@tessi.fr>
 */

namespace Tms\Bundle\LoggerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

/**
 * @ORM\Entity(repositoryClass="Tms\Bundle\LoggerBundle\Entity\Repository\LogRepository")
 * @ORM\Table(name="log", indexes={
 *     @ORM\Index(name="log_hash", columns={"hash"}),
 *     @ORM\Index(name="log_object", columns={"object_class_name", "object_id"}),
 *     @ORM\Index(name="log_action", columns={"action"})
 * })
 */
class Log
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class_name", type="string", length=128)
     */
    private $objectClassName;

    /**
     * @var string
     *
     * @ORM\Column(name="object_id", type="string", length=64)
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $information;

    public function __construct(LoggableInterface $object, $action, $information = null)
    {
        $reflection = new \ReflectionClass($object);
        $this
            ->setCreatedAt(new \DateTime())
            ->setHash(self::generateHash($object))
            ->setObjectClassName($reflection->getName())
            ->setObjectId($object->getId())
            ->setAction($action)
            ->setInformation($information)
        ;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Log
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set hash.
     *
     * @param string $hash
     *
     * @return Log
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set objectClassName.
     *
     * @param string $objectClassName
     *
     * @return Log
     */
    public function setObjectClassName($objectClassName)
    {
        $this->objectClassName = $objectClassName;

        return $this;
    }

    /**
     * Get objectClassName.
     *
     * @return string
     */
    public function getObjectClassName()
    {
        return $this->objectClassName;
    }

    /**
     * Set objectId.
     *
     * @param string $objectId
     *
     * @return Log
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId.
     *
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set action.
     *
     * @param string $action
     *
     * @return Log
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set user.
     *
     * @param string $user
     *
     * @return Log
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set source.
     *
     * @param string $source
     *
     * @return Log
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return Log
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set information.
     *
     * @param string $information
     *
     * @return Log
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information.
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Generate hash.
     *
     * @param LoggableInterface $object
     *
     * @return string
     */
    public static function generateHash(LoggableInterface $object)
    {
        $reflection = new \ReflectionClass($object);
        $hash = md5(sprintf('%s-%s',
                $reflection->getName(),
                $object->getId()
        ));

        return $hash;
    }
}
