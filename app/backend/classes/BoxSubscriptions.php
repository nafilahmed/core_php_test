
<?php

class BoxSubscriptions
{
    private $_db,
            $_data,
            $_allData,
            $_sessionName;

    public function __construct($boxSubscriptions = null)
    {
        $this->_db = Database::getInstance();
        if (! $boxSubscriptions)
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

        if (!$this->_db->update('box_subscriptions', $id, $fields))
        {
            throw new Exception('Unable to update the user.');
        }
    }

    public function create($fields = array())
    {        
        if (!$this->_db->insert('box_subscriptions', $fields))
        {
            throw new Exception("Unable to create the user.");
        }
    }

    public function getAll()
    {
        $sql = "SELECT box_subscriptions.id as id,box_subscriptions.user_id, boxes.id as box_id, boxes.name as name, azans.name AS azan, azans.path, time_zones.name AS time_zone  FROM box_subscriptions 
                RIGHT JOIN boxes ON box_subscriptions.box_id = boxes.id 
                INNER JOIN azans ON boxes.azan_id = azans.id 
                INNER JOIN time_zones ON boxes.time_zone_id = time_zones.id GROUP BY box_subscriptions.box_id";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            $this->_allData = $data;
            return true;
        }
    }

    public function find($userId = null)
    {
        if ($userId)
        {
            $sql = "SELECT time_zones.id as time_zone_id, time_zones.name AS time_zone  FROM box_subscriptions 
                RIGHT JOIN boxes ON box_subscriptions.box_id = boxes.id 
                INNER JOIN time_zones ON boxes.time_zone_id = time_zones.id where box_subscriptions.user_id = ".$userId." LIMIT 1";

            $data = $this->_db->customQuery($sql);


            if (count($data) > 0)
            {
                $this->_data = $data;
                return json_encode($this->_data[0]);
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

        if (!$this->_db->delete('box_subscriptions', array('id', '=', $id)))
        {
            throw new Exception('Unable to update the user.');
        }
    }
}
