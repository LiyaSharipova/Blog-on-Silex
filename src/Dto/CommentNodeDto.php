<?php

namespace Dto;
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 20.06.17
 * Time: 23:48
 */
class CommentNodeDto
{
    private $content;
    private $date;
    private $user;
    private $childs = array();
    private $inheritanceLevel;

    /**
     * CommentNodeDto constructor.
     */
    public function __construct()
    {
        $this->childs = array();
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return CommentNodeDto
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return CommentNodeDto
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return CommentNodeDto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * @param mixed $childs
     * @return CommentNodeDto
     */
    public function setChilds($childs)
    {
        $this->childs = $childs;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInheritanceLevel()
    {
        return $this->inheritanceLevel;
    }

    /**
     * @param mixed $inheritanceLevel
     */
    public function setInheritanceLevel($inheritanceLevel)
    {
        $this->inheritanceLevel = $inheritanceLevel;
    }

}