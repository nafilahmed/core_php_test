
<div class="container" style="padding-top: 5%; padding-bottom: 5%;">
<h2>Register Form</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="name">Name :</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php echo escape(Input::get('name')); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email :</label>
      <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo escape(Input::get('email')); ?>">
    </div>
    <div class="form-group">
      <label for="password">Password :</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <div class="form-group">
      <label for="password_again">Confirm Password :</label>
      <input type="password" class="form-control" id="password_again" placeholder="Confirm your password" name="password_again">

    <input type="submit" value="Register me">
    </div>
  </form>
</div>
