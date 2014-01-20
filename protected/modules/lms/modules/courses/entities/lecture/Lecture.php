<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecture
 *
 * @ORM\Entity
 * @ORM\Table(name="lecture")
 */
class Lecture extends CFormModel
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
     * @var Step
     *
     * @ORM\ManyToOne(targetEntity="Step")
     * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
     */
    private $step;

    /**
     * @var Video
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="lecture")
     */
    private $videos;

    /**
     * @var Document
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

}