<?php

namespace Rendes\Modules\Courses\Entities\Quiz\Questions;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Rendes\Modules\Courses\Repositories\QuestionRepository")
 */
class VariantQuestion extends Question implements \Rendes\Modules\Courses\Interfaces\Quiz\Questions\IVariantQuestion
{
    /**
     * @var Array
     *
     * @ORM\Column(name="variants", type="array")
     */
    private $variants;


    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param Array $variants
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
    }




}
