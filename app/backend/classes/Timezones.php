
<?php

class Timezones
{
    private $_db,
            $_data,
            $_allData,
            $_sessionName;

    public function __construct($timeZones = null)
    {
        $this->_db = Database::getInstance();
        if (! $timeZones)
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

        if (!$this->_db->update('time_zones', $id, $fields))
        {
            throw new Exception('Unable to update the time zone.');
        }
    }

    public function create($fields = array())
    {        
        if (!$this->_db->insert('time_zones', $fields))
        {
            throw new Exception("Unable to create the time zone.");
        }
    }

    public function getAllWRTNamaz()
    {
        $sql = "SELECT time_zones.id as t_id, time_zones.name as t_name FROM time_zones
        INNER JOIN namaz_times ON time_zones.id = namaz_times.time_zone_id GROUP BY time_zones.id";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            return $data;
        }
    }

    public function getAll()
    {
        $sql = "SELECT time_zones.id as t_id, time_zones.name as t_name FROM time_zones";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            $this->_allData = $data;
            return true;
        }
    }

    public function find($timeZones = null)
    {
        if ($timeZones)
        {
            $data = $this->_db->get('time_zones', array('id', '=', $timeZones));

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

        if (!$this->_db->delete('time_zones', array('id', '=', $id)))
        {
            throw new Exception('Unable to update the time zone.');
        }
    }
}
