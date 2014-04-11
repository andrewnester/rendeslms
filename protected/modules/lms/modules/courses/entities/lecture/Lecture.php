<?php

namespace Rendes\Modules\Courses\Entities\Lecture;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecture
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\LectureRepository")
 * @ORM\Table(name="lecture")
 * @ORM\HasLifecycleCallbacks
 */
class Lecture extends \CFormModel
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
     * @var \Rendes\Modules\Courses\Entities\Step
     *
     * @ORM\ManyToOne(targetEntity="\Rendes\Modules\Courses\Entities\Step")
     * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
     */
    private $step;

    /**
     * @var \Rendes\Modules\Courses\Entities\Lecture\Video
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="lecture")
	 * @ORM\OrderBy({"order" = "ASC"})
     */
    private $videos;

    /**
     * @var \Rendes\Modules\Courses\Entities\Lecture\Document
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="lecture")
	 * @ORM\OrderBy({"order" = "ASC"})
     */
    private $documents;

	/**
	 * @var \Rendes\Modules\Courses\Entities\Lecture\Slide
	 *
	 * @ORM\OneToMany(targetEntity="Slide", mappedBy="lecture")
	 * @ORM\OrderBy({"order" = "ASC"})
	 */
	private $slides;

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
     * @var integer
     *
     * @ORM\Column(name="order_position", type="integer", nullable=false)
     */
    private $order;


    public function rules(){
        return array(
            array('name, description', 'required'),
        );
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
     * @param \Rendes\Modules\Courses\Entities\Lecture\Document $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Lecture\Document
     */
    public function getDocuments()
    {
        return $this->documents;
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
     * @param \Rendes\Modules\Courses\Entities\Lecture\Video $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return \Rendes\Modules\Courses\Entities\Lecture\Video
     */
    public function getVideos()
    {
        return $this->videos;
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
	 * @param \Rendes\Modules\Courses\Entities\Lecture\Slide $slides
	 */
	public function setSlides($slides)
	{
		$this->slides = $slides;
	}

	/**
	 * @return \Rendes\Modules\Courses\Entities\Lecture\Slide
	 */
	public function getSlides()
	{
		return $this->slides;
	}

	/** @ORM\PrePersist */
	public function onPersist()
	{
		$this->order = 0;
	}


}