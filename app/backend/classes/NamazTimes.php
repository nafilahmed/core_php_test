
<?php

class NamazTimes extends User
{
    private $_db,
            $_data,
            $_allData,
            $_sessionName;

    public function __construct($namazTimes = null)
    {
        $this->_db = Database::getInstance();
        if (! $namazTimes)
        {
            $this->getAll();
        }
    }

    public function create($fields = array())
    {        
        if (!$this->_db->insert('namaz_times', $fields))
        {
            throw new Exception("Unable to create the namaz time.");
        }
    }

    public function getAll()
    {
        $sql = "SELECT *  FROM namaz_times";
        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            $this->_allData = $data;
            return true;
        }
    }

    public function find($namazTimeID = null)
    {
        if ($namazTimeID)
        {
            $data = $this->_db->get('namaz_times', array('id', '=', $namazTimeID));

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

    public function allNamaz()
    {
        return ['imsak','fajr','syuruk','dhuhr','asr','maghrib','isha'];
    }


    public function getNamazTime($timeZoneId,$date)
    {

        $data = [];

        $sql = "SELECT CASE WHEN datetime > NOW() THEN 'have' ELSE 'passed' END as isha_time FROM namaz_times WHERE namaz = 'isha' AND DATE(datetime) = '".$date."' ";

        $data = $this->_db->customQuery($sql);

        if (count($data) > 0)
        {
            if($data[0]->isha_time == 'passed' ){

                $date = date("Y-m-d", strtotime($date." +1 day"));
            }

            $sql = "SELECT * FROM namaz_times WHERE datetime >= NOW() AND time_zone_id = ".$timeZoneId." AND DATE(datetime) = '".$date."' LIMIT 1";

            $data = $this->_db->customQuery($sql);

            $res = !empty($data) ? json_encode($data[0]) : null;
            
            return $res;
        }

        return null;
    }

    public function deleteMe($timeZoneId = null)
    {
        try {

            if ($this->_db->delete('namaz_times', array('time_zone_id', '=', $timeZoneId)))
            {
                return true;
            }            

        } catch(Exception $e){
            die(print_r($e,1));
        }
    }
}
