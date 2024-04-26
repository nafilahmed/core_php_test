<?php

class Boxes extends User
{
    private $_db,
            $_data,
            $_allData,
            $_sessionName;

    public function __construct($boxes = null)
    {
        $this->_db = Database::getInstance();
        if (! $boxes)
        {
            $this->getAll();
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && parent::isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('boxes', $id, $fields))
        {
            throw new Exception('Unable to update the box.');
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('boxes', $fields))
        {
            throw new Exception("Unable to create the box.");
        }
    }

    public function getAll()
    {
        $sql = "SELECT boxes.*,azans.name AS azan,azans.path, time_zones.name AS time_zone  FROM boxes 
                INNER JOIN azans ON boxes.azan_id = azans.id 
                INNER JOIN time_zones ON boxes.time_zone_id = time_zones.id";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            $this->_allData = $data;
            return true;
        }
    }

    public function find($box = null)
    {
        if ($box)
        {
            $data = $this->_db->get('boxes', array('id', '=', $box));

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
        if ($this->_allData == null)
        {
            $this->getAll();
        }

        return $this->_allData;
    }

    public function deleteMe()
    {
        if (parent::isLoggedIn())
        {
            $id = $this->data()->id;
        }

        if (!$this->_db->delete('boxes', array('id', '=', $id)))
        {
            throw new Exception('Unable to update the box.');
        }
    }
}
