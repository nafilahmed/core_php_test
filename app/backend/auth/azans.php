<?php

$azan = new Azans();

if (! $user->isLoggedIn() || $user->data()->role_id != 1)
{
     Redirect::to('index.php');
}

$azanData = "";

if(isset($_GET['id'])){
     $azanData = json_decode($azan->find($_GET['id']),1);
}

if(Input::exists()){

     $validate = new Validation();

     $validation = $validate->check($_POST, array(
          'name'  => array(
               'required'  => true,
               'min'       => 2,
               'max'       => 50
          )
     ));

     if ($validation->passed())
     {
          try {

               if(!empty($_FILES["path"]["name"])){

                    $target_dir = FRONTEND_ASSET."audio/";
                    $target_file = $target_dir . basename($_FILES["path"]["name"]);
                    $uploadOk = 1;
                    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    // Check if file already exists
                    if (file_exists($target_file)) {
                         Session::flash('error', "Sorry, file already exists.");
                         $uploadOk = 0;
                    }

                    // Check file size
                    if ($_FILES["path"]["size"] > 500000) {
                         Session::flash('error', "Sorry, your file is too large.");
                         $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($fileType != "mp3" ) {
                         Session::flash('error', "Sorry, only mp3 files are allowed.");
                         $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                         Session::flash('error', "Sorry, your file was not uploaded.");
                    
                    } else { // if everything is ok, try to upload file

                         if (move_uploaded_file($_FILES["path"]["tmp_name"], $target_file)) {
                              
                              $queryData = ['name'  => Input::get('name'),'path'  => $target_file];

                         } else {
                              Session::flash('error', "Sorry, there was an error uploading your file.");
                         }
                    }
               }else{
                    $queryData = ['name'  => Input::get('name')];
               }


               if (empty(Input::get('id'))) {

                    $azan->create($queryData);

                    Session::flash('update-success', 'Azan successfully created!');                    

               } else {

                    $azan->update($queryData,Input::get('id'));

                    Session::flash('update-success', 'Azan successfully updated!');
               }

               Redirect::to('azans.php');

          } catch(Exception $e){
               die($e->getMessage());
          }
     }

     else
     {
          echo '<div class="alert alert-danger"><strong>' . cleaner($validation->error()) . '</strong></div>';
     }

}


