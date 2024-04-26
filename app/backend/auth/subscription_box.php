<?php

$box = new Boxes();

if (! $user->isLoggedIn() || $user->data()->role_id != 1)
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
          'name'  => array(
               'required'  => true,
               'min'       => 2,
               'max'       => 50
          ),
          'time_zone'  => array(
               'required'  => true,
          ),
     ));

     if ($validation->passed())
     {
          try {

               if (empty(Input::get('id'))) {
                    
                    $box->create(array(
                         'name'  => Input::get('name'),
                         'time_zone_id'  => Input::get('time_zone'),
                         'azan_id'  => 1,
                    ));

                    Session::flash('update-success', 'Box successfully created!');                    

               } else {

                    $box->update(array(
                         'name'  => Input::get('name'),
                         'time_zone_id'  => Input::get('time_zone'),
                         'azan_id'  => 1,                         
                    ),Input::get('id'));

                    Session::flash('update-success', 'Box successfully updated!');
               }
               

               Redirect::to('subscription_box.php');

          } catch(Exception $e){
               die($e->getMessage());
          }
     }

     else
     {
          echo '<div class="alert alert-danger"><strong></strong>' . cleaner($validation->error()) . '</div>';
     }

}


