
<?php

class Azans
{
    private $_db,
            $_data,
            $_allData,
            $_sessionName;

    public function __construct($azans = null)
    {
        $this->_db = Database::getInstance();
        if (! $azans)
        {
            $this->getAll();
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && $user->isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('azans', $id, $fields))
        {
            throw new Exception('Unable to update the user.');
        }
    }

    public function create($fields = array())
    {        
        if (!$this->_db->insert('azans', $fields))
        {
            throw new Exception("Unable to create the user.");
        }
    }

    public function getAll()
    {
        $sql = "SELECT *  FROM azans";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            $this->_allData = $data;
            return true;
        }
    }

    public function find($anan = null)
    {
        if ($anan)
        {
            $data = $this->_db->get('azans', array('id', '=', $anan));

            if ($data->count())
            {
                $this->_data = $data->first();
                return json_encode($this->_data);
            }
        }
    }

    public function data()
    {
        return $this->_data;
    }

    public function allData()
    {
        return $this->_allData;
    }

    public function deleteMe()
    {
        if ($user->isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->delete('azans', array('id', '=', $id)))
        {
            throw new Exception('Unable to update the user.');
        }
    }
}
