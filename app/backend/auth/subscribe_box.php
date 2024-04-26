<?php

$box = new Boxes();
$boxSubscriptions = new BoxSubscriptions();

if (! $user->isLoggedIn())
{
     Redirect::to('index.php');
}

$boxData = "";

if(isset($_GET['id'])){
     $boxData = json_decode($box->find($_GET['id']),1);
}

if(Input::exists()){
     $validate = new Validation();

     $validation = $validate->check($_POST, array(
          'box_id'  => array(
               'required'  => true,
          ),
     ));

     if ($validation->passed())
     {
          try {                    
               $boxSubscriptions->create(array(
                    'box_id'  => Input::get('box_id'),
                    'user_id'  => $user->data()->id,
                    'updated_at'  => date("Y-m-d h:i:s"),
               ));

               $subscriptionData = json_decode($user->getUserSubscribedData($user->data()->id),1);

               Session::put('subscription_data', $subscriptionData);

               Session::flash('update-success', 'Box subscribed successfully');
               
               Redirect::to('subscribe_box.php');

          } catch(Exception $e){
               die($e->getMessage());
          }
     }

     else
     {
          echo '<div class="alert alert-danger"><strong></strong>' . cleaner($validation->error()) . '</div>';
     }

}


