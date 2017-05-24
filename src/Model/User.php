<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 24.05.17
 * Time: 2:28
 */

namespace Model;
use Symfony\Component\Validator\Constraints as Assert;


class User
{

    /**
     * @Assert\NotBlank()
     */
    protected $login;
    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;
}