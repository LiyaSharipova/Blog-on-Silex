<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 17.06.17
 * Time: 14:43
 */

namespace Model;


class Post
{
    private $ts;
    private $author;
    private $title;
    private $content;

    /**
     * Post constructor.
     * @param $author
     * @param $title
     * @param $content
     */
    public function __construct(User $author, $title, $content)
    {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
    }


    /**
     * @return mixed
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @param mixed $ts
     */
    public function setTs($ts)
    {
        $this->ts = $ts;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}