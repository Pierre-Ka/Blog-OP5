<?php

namespace BlogApp\Manager;

use BlogApp\Entity\User;

class UserManager extends Manager
{
    public function login($email_submit, $password_submit)
    {
        $email_submit = htmlspecialchars($email_submit);
        $password_submit = htmlspecialchars($password_submit);

        $q = $this->_db->prepare('SELECT * FROM user WHERE email=:email AND is_valid=1');
        $q->bindValue('email', $email_submit);
        $q->execute();

        $result = $q->fetch();
        if ($result) {
            if (($result['password']) === sha1($password_submit)) {
                $_SESSION['auth'] = $result['id'];
                return true;
            }
        }
        return false;
    }

    public function logged()
    {
        if ($_SESSION['auth']) {
            return true;
        }
    }

    public function isAdmin()
    {
        $id = $_SESSION['auth'] ?? null;
        if ($id) {
            $q = $this->_db->prepare('SELECT * FROM user WHERE id =:id AND is_admin=1');
            $q->bindValue('id', $id);
            $q->execute();
            $data = $q->fetch();
            if ($data) {
                return true;
            }
        }
    }

    public function getUserId()
    {
        if ($this->logged()) {
            return ($_SESSION['auth']);
        }
    }

    public function add(User $user)
    {
        $q = $this->_db->prepare('INSERT INTO user(email, password, name, description, picture, inscription_date) VALUES (:email, :password, :name, :description, :picture, NOW())');
        $q->bindValue('email', $user->getEmail());
        $q->bindValue('password', sha1($user->getPassword()));
        $q->bindValue('name', $user->getName());
        $q->bindValue('description', $user->getDescription());
        $q->bindValue('picture', 'USER_IMG.jpg');
        $q->execute();
    }

    public function getOne(int $info)
    {
        $q = $this->_db->prepare('SELECT * FROM user WHERE id= :id');
        $q->bindValue('id', $info);
        $q->execute();
        $data = $q->fetch();
        return new User($data);
    }

    public function getAuthorName(int $user_id)
    {
        $q = $this->_db->prepare('SELECT * FROM user WHERE id= :id');
        $q->bindValue('id', $user_id);
        $q->execute();
        $data = $q->fetch(\PDO::FETCH_ASSOC);
        return $data['name'];
    }

    public function edit(User $user)
    {
        $q = $this->_db->prepare('UPDATE user SET password = :password, name = :name, picture = :picture, description = :description WHERE id = :id');
        $q->execute(array(
            'id' => $user->getId(),
            'password' => $user->getPassword(),
            'name' => $user->getName(),
            'picture' => $user->getPicture(),
            'description' => $user->getDescription()
        ));
        return $q;
    }

    public function valid($info)
    {
        if (ctype_digit($info)) {
            $q = $this->_db->prepare('UPDATE user SET is_valid=1 WHERE id=:id');
            $q->bindValue('id', $info);
            $q->execute();
        }
    }

    public function delete($info)
    {
        if (ctype_digit($info)) {
            if ($info > 1) {
                $q = $this->_db->prepare('DELETE FROM user WHERE id=:id');
                $q->bindValue('id', $info);
                $q->execute();
            }
        }
    }

    public function getList()
    {
        $users = [];
        $q = $this->_db->query('SELECT id,email, name, picture, description, is_valid, DATE_FORMAT(inscription_date, \'%d/%m/%Y\') AS inscription_date FROM user WHERE is_admin = 0 ORDER BY DATE_FORMAT(inscription_date, \'%Y%m%d%Hh%imin%ss\') DESC');
        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new User ($data);
        }
        return $users;
    }
}
