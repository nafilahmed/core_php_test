<?php

class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();

        $this->_sessionName = Config::get('session/session_name');

        if (! $user)
        {
            if (Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);

                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
            }

        }
        else
        {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('users', $id, $fields))
        {
            throw new Exception('Unable to update the user.');
        }
    }

    public function create($fields = array())
    {
        
        if (!$this->_db->insert('users', $fields))
        {
            throw new Exception("Unable to create the user.");
        }
    }

    public function getUserSubscribedData($userId = null)
    {
        $sql = "SELECT users.id as u_id, time_zones.id AS time_zone_id, time_zones.name AS time_zone, boxes.id AS boxe_id, box_subscriptions.id AS box_subscription_id,  azans.id AS azan_id, azans.path AS azan_path  FROM users 
            INNER JOIN box_subscriptions ON users.id = box_subscriptions.user_id 
            INNER JOIN boxes ON box_subscriptions.box_id = boxes.id 
            INNER JOIN azans ON boxes.azan_id = azans.id 
            INNER JOIN time_zones ON boxes.time_zone_id = time_zones.id WHERE users.id = ".$userId." LIMIT 1";

        $data = $this->_db->customQuery($sql);
        if (count($data) > 0)
        {
            return json_encode($data[0]);
        }
        return null;
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field  = (is_numeric($user)) ? 'id' : 'email';


            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count())
            {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function login($email = null, $password = null, $remember = false)
    {
        if (! $email && ! $password && $this->exists())
        {
            Session::put($this->_sessionName, $this->data()->id);
        }
        else
        {
            $user = $this->find($email);

            if ($user)
            {
                if (Password::check($password, $this->data()->password))
                {
                    Session::put($this->_sessionName, $this->data()->id);

                    Session::put('role_id', $this->data()->id);

                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermission($key)
    {
        $group = $this->_db->get('roles', array('role_id', '=', $this->data()->roles));

        if  ($group->count())
        {
            $permissions = json_decode($group->first()->permissions, true);

            if ($permissions[$key] == true)
            {
                return true;
            }
        }

        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout()
    {
        session_destroy();
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function deleteMe()
    {
        if ($this->isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->delete('users', array('id', '=', $id)))
        {
            throw new Exception('Unable to update the user.');
        }
    }
}
