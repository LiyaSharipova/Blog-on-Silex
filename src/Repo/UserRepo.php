<?php
/**
 * Created by PhpStorm.
 * User: liya
 * Date: 19.06.17
 * Time: 0:27
 */

namespace Repo;


use Model\User;
use Repo\Interfaces\IUserRepo;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserRepo extends BaseRepo implements IUserRepo
{

    function insert(User $user)
    {
        // TODO: Implement insert() method.
        $this->db->insert('user', array(
            'login' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'roles' => 'ROLE_USER'
        ));
    }

    function getUser()
    {
//        $token = $application->get('security.token_storage')->getToken();
//        if (null != $token):
//            $user = $token->getUser();
        $user = $this->_app['security.token_storage']->getToken()->getUser();

        return $this->getByUsername($user->getUsername());
//        endif;
    }


    function getByUsername($username)
    {
        $stmt = $this->db->executeQuery('SELECT * FROM user WHERE login = ?', array(strtolower($username)));

        if (!$user = $stmt->fetch()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        $currentUser = new User($user['login'], $user['password'], explode(',', $user['roles']), true, true, true, true);
        $currentUser->setId($user['id']);
        $currentUser->setPhoto("PHOTO");
        $currentUser->setEmail($user['email']);

        return $currentUser;

    }

    function getById($id)
    {
        $stmt = $this->db->executeQuery('SELECT * FROM user WHERE id = ?', array(strtolower($id)));
        $user = $stmt->fetch();
        $currentUser = new User($user['login'], $user['password'], explode(',', $user['roles']), true, true, true, true);
        $currentUser->setId($user['id']);
        $currentUser->setPhoto($user['photo']);
        $currentUser->setEmail($user['email']);
        return $currentUser;
    }
}