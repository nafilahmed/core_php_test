<?php
require_once 'start.php';

$namazTime = new NamazTimes();

$boxSubscription = new BoxSubscriptions();

$timezones = new Timezones();

if(isset($_POST['sync_name_time'])){

	try
	{
		foreach ($timezones->allData() as $key => $value) {


			$boxSubscriptionData = json_decode($boxSubscription->find($user->data()->id),1);

			$namazTime->deleteMe($value->t_id);

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://www.e-solat.gov.my/index.php?r=esolatApi%2FTakwimSolat&period=week&zone='.$value->t_name,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Cookie: PHPSESSID=mfl8kjcm430n24g9pb69ovktnn; TS01ca5017=01714ff3616af16b36d427c37cdc7db5b05d7d27e6b1a7e592ccbf2207af533b9d334b7e502ceb36508ff5f35247d919a583387967ea0899a2e0ce0b3a166ac15dc0f0c0ea'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response,1);

			if(empty($response)){

				Session::flash('error', 'Namaz Sync Failed Try Manually');

				echo json_encode([ "status" => 400, "message"=>"Namaz Sync Failed Try again Manually" ]);
			}else{

				foreach ($response['prayerTime'] as $key => $value2) {

					foreach ($namazTime->allNamaz() as $key2 => $value3) {

						$newDateFormat = date('Y-m-d H:i:s', strtotime($value2['date'].' '.$value2[$value3]));

						$namazTime->create(array(
							'time_zone_id'  => $value->t_id,
							'namaz'  => $value3,
							'datetime'  => $newDateFormat,
							'updated_at'  => date("Y-m-d h:i:s"),
						));
					}

				}

				Session::flash('update-success', 'Namaz Sync Successfully');

				echo json_encode([ "status"=>200, "message"=>"Namaz Sync Successfully" ]);
			}

		}


	}
	catch(Exception $e)
	{
		die(print_r($e,1));
	}

}


if(isset($_POST['get_namaz_time'])){

	try
	{
		echo json_encode($namazTime->getNamazTime(Session::get('subscription_data')['time_zone_id'],$_POST['c_date']));

	}
	catch(Exception $e)
	{
		die(print_r($e,1));
	}

}