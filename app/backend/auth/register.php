<?php
require_once 'app/backend/core/Init.php';


if(Input::exists())
{

    $validate = new Validation();

    $validation = $validate->check($_POST, array(
        'name' => array(
            'required' => true,
            'min' => 2,
            'max' => 50
        ),

        'email' => array(
            'required' => true,
            'min' => 2,
            'max' => 20,
            // 'unique' => 'users'
        ),

        'password' => array(
            'required' => true,
            'min' => 6
        ),

        'password_again' => array(
            'required' => true,
            'matches' => 'password'
        )
    ));

    if ($validate->passed())
    {
        try
        {            
            $user->create(array(
                'email'  => Input::get('email'),
                'password'  => Input::get('password'),
                'name'      => Input::get('name'),
                'created_at'    => date('Y-m-d H:i:s'),
                'role_id'    => 2
            ));

            Session::flash('register-success', 'Thanks for registering! You can login now.');
            Redirect::to('index.php');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
    {
        foreach ($validate->errors() as $error)
        {
            echo '<div class="alert alert-danger"><strong></strong>' . cleaner($error) . '</div>';
        }
    }
}
