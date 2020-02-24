<?php

/**
 * @author Nabil Mansouri <nabil.mansouri@tessi.fr>
 */

namespace Tms\Bundle\LoggerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

/**
 * @ODM\Document(collection="logs")
 * @ODM\HasLifecycleCallbacks
 * @ODM\Indexes({
 *   @ODM\Index(keys={"object_id"="asc"}, name="object_id"),
 *   @ODM\Index(keys={"user"="asc"}, name="users"),
 *   @ODM\Index(keys={"action"="desc"}, name="actions"),
 *   @ODM\Index(keys={"source"="asc"}, name="sources"),
 *   @ODM\Index(keys={"hash"="asc"}, name="hashs", unique=true)
 * })
 */
class Log
{
	/**
     * The log id.
     *
     * @var \MongoId
     *
     * @ODM\Id
     */
    private $id;

    /**
     * @var datetime
     *
     * @ODM\Field(type="date")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ODM\Field(type="string", length=255)
	 */
    private $hash;

    /**
     * @var string
     *
     * @ODM\Field(type="string", length=128)
     */
    private $objectClassName;

    /**
     * @var string
     *
     * @ODM\Field(name="object_id", type="string", length=64)
     */
    private $objectId;

    /**
     * @var string
     *
     * @ODM\Field(type="string", length=64)
     */
    private $action;

	/**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $user;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $source;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    private $comment;

    /**
     * @var string
     *
     * @ODM\Field(type="text", nullable=true)
     */
    private $information;

    public function __construct(LoggableInterface $object, $action, $information = null, $comment = null)
    {
        $reflection = new \ReflectionClass($object);
        $this
            ->setCreatedAt(new \DateTime())
            ->setHash(self::generateHash($object))
            ->setObjectClassName($reflection->getName())
            ->setObjectId($object->getId())
            ->setAction($action)
            ->setComment($comment)
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

        return md5(sprintf('%s-%s',
            $reflection->getName(),
            $object->getId()
        ));
    }
}
