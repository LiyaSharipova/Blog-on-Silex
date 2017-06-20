<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 18.06.17
 * Time: 12:54
 */

namespace Repo;


use Silex\Application;

class BaseRepo
{
    protected $db;
    protected $_app;

    /**
     * BaseRepo constructor.
     * @param $db
     * @param $app
     */
    public function __construct($db, Application $app)
    {
        $this->db = $db;
        $this->_app = $app;
    }


}