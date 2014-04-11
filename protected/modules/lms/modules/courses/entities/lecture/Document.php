<?php

namespace Rendes\Modules\Courses\Entities\Lecture;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\DocumentRepository")
 * @ORM\Table(name="document")
 * @ORM\HasLifecycleCallbacks
 */
class Document extends \CFormModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Lecture
     *
     * @ORM\ManyToOne(targetEntity="Lecture")
     * @ORM\JoinColumn(name="lecture_id", referencedColumnName="id")
     */
    private $lecture;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255, nullable=false)
     */
    private $src;

    /**
     * @var string
     */
    private $doc;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_position", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;


    public function rules()
    {
        return array(
            array('name, description', 'required'),
            array('doc', 'file', 'on' => 'create',
                'types'=>'doc, docx, pdf'
            ),
            array('doc', 'file', 'on' => 'update',
                'allowEmpty' => true,
                'types'=>'doc, docx, pdf'
            ),
        );
    }


    public function attributeNames()
    {
        return array('name', 'description', 'doc');
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Rendes\Modules\Courses\Entities\Lecture\Lecture $lecture
     */
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Lecture\Lecture
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function setDoc($doc)
    {
        $this->doc = $doc;
    }

    public function getDoc()
    {
        return $this->doc;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }





	/** @ORM\PrePersist */
	public function onPersist()
	{
		$this->order = 0;
		$this->created = new \DateTime();
		$this->updated = new \DateTime();
	}

    /** @ORM\PreUpdate */
    public function setUpdatedDate()
    {
        $this->updated = new \DateTime();
    }


}