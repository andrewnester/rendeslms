<?php

namespace Rendes\Modules\Courses\Entities\Lecture;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecture
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\LectureRepository")
 * @ORM\Table(name="lecture")
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
     */
    private $videos;

    /**
     * @var \Rendes\Modules\Courses\Entities\Lecture\Document
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="lecture")
     */
    private $documents;

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
     * @var Array
     *
     * @ORM\Column(name="passing_rules", type="array")
     */
    private $passingRules;

    /**
     * @ORM\ManyToMany(targetEntity="Document")
     * @ORM\JoinTable(name="required_to_pass_documents",
     *      joinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="document_id", referencedColumnName="id")}
     *      )
     */
    private $requiredToPassDocuments;

    /**
     * @ORM\ManyToMany(targetEntity="Video")
     * @ORM\JoinTable(name="required_to_pass_videos",
     *      joinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="video_id", referencedColumnName="id")}
     *      )
     */
    private $requiredToPassVideos;

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

    public function __construct()
    {
        $this->requiredToPassDocuments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->requiredToPassVideos = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function isPassed()
    {
        $lectureService = new \Rendes\Modules\Courses\Services\LectureService();
        return $lectureService->isPassed($this);
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
     * @param Array $passingRules
     */
    public function setPassingRules($passingRules)
    {
        $this->passingRules = $passingRules;
    }

    /**
     * @return Array
     */
    public function getPassingRules()
    {
        return $this->passingRules ? $this->passingRules : array();
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




    public function setRequiredToPassDocuments($requiredToPassDocuments)
    {
        $this->requiredToPassDocuments = $requiredToPassDocuments;
    }

    public function getRequiredToPassDocuments()
    {
        return $this->requiredToPassDocuments;
    }

    public function setRequiredToPassVideos($requiredToPassVideos)
    {
        $this->requiredToPassVideos = $requiredToPassVideos;
    }

    public function getRequiredToPassVideos()
    {
        return $this->requiredToPassVideos;
    }




}