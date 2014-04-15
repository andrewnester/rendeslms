<?php

namespace Rendes\Modules\Courses\Entities\TinCan;

use Doctrine\ORM\Mapping as ORM;

/**
 * TinCanObject
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\TinCanRepository")
 * @ORM\Table(name="tincan_object")
 * @ORM\HasLifecycleCallbacks
 */
class TinCanObject extends \CFormModel
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

	/**
	 * @var \Rendes\Modules\Courses\Entities\Step
	 *
	 * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Step")
	 * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
	 */
	private $step;


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



    public function __construct()
    {

    }

    public function rules(){
        return array(
            array('name, description', 'required'),
        );
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

	/**
	 * @param \Rendes\Modules\Courses\Entities\Step $step
	 */
	public function setStep($step)
	{
		$this->step = $step;
	}

	/**
	 * @return \Rendes\Modules\Courses\Entities\Step
	 */
	public function getStep()
	{
		return $this->step;
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







    /** @ORM\PrePersist */
    public function setCreationDate()
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