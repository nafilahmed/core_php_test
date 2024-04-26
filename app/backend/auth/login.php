<?php
require_once 'app/backend/core/Init.php';

if (Input::exists()) {
    $validate   = new Validation();

    $validation = $validate->check($_POST, array(
        'email'  => array(
            'required'  => true,
            ),

        'password'  => array(
            'required'  => true
            ),
    ));

    if ($validation->passed())
    {
        $remember   = (Input::get('remember') === 'on') ? 1 : 0;

        $login      = $user->login(Input::get('email'), Input::get('password'), $remember);

        if ($login)
        {

            $subscriptionData = json_decode($user->getUserSubscribedData($user->data()->id),1);
            

            Session::put('subscription_data', $subscriptionData);
            
            Redirect::to('index.php');
        }
        else
        {
            echo '<div class="alert alert-danger"><strong></strong>Incorrect Credentials! Please try again...</div>';
        }
    }
    else
    {
        foreach ($validation->errors() as $error)
        {
            echo '<div class="alert alert-danger"><strong></strong>' . cleaner($error) . '</div>';
        }
    }
}

?>

<script type="text/javascript">
    $(document).ready(function(){
        localStorage.clear();
    });
</script>
