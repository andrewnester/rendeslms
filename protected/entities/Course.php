<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 12
 * Date: 17.11.13
 * Time: 16:06
 * To change this template use File | Settings | File Templates.
 */

class Course extends CModel
{
    private $id;
    private $teacherID;
    private $name;
    private $description;
    private $isPublic;
    private $created;
    private $updated;


    public function attributeNames()
    {
        return array();
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $teacherID
     */
    public function setTeacherID($teacherID)
    {
        $this->teacherID = $teacherID;
    }

    /**
     * @return mixed
     */
    public function getTeacherID()
    {
        return $this->teacherID;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }


}