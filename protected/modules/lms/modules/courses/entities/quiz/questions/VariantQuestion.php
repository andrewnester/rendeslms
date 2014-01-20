<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class VariantQuestion extends Question implements IVariantQuestion
{
    /**
     * @var Array
     *
     * @ORM\Column(name="variants", type="array")
     */
    private$variants;


    public function getVariants()
    {
        return $this->variants;
    }

    public function getQuestion()
    {
        // TODO: Implement getQuestion() method.
    }

    public function getAnswers()
    {
        // TODO: Implement getAnswers() method.
    }

    public function getConfiguration()
    {
        // TODO: Implement getConfiguration() method.
    }

    public function getResult($proposedAnswers)
    {
        // TODO: Implement getResult() method.
    }


}
