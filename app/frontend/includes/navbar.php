<header data-bs-theme="dark">

  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-green">
    <div class="container">
      <a class="navbar-brand" href="#">Time to Pray</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
      <ul class="navbar-nav mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if ($user->isLoggedIn()): ?>
          <?php if ($user->data()->role_id == 1): ?>
          <li class="nav-item">
            <a class="nav-link" href="subscription_box.php"></span> Prayer Box</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="azans.php"></span> Azan</a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="subscribe_box.php"></span> Subscribe Box</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="logout" href="logout.php"></span> Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="register.php"></span> Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php"></span> Log-in</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
</header>
<main>

  <div class="container-fluid bg-body-secondary">
    <div class="container p-4 p-md-5 mb-4 rounded text-body-emphasis">
      <div class="col-lg-12 px-0">
        <?php if ($user->isLoggedIn()): ?>

          <?php if (!empty(Session::get('subscription_data'))): ?>

            <h1 class="display-4 fst-italic">Up Comming Namaz !</h1>

            <p class="lead my-3 text-dark">Namaz-e-<span id="namaz_name"></span> at <span id="hour"></span>:<span id="minutes"></span></p>

            <div>
              <button id="sync_prayer_time" class="btn btn-secondary">Sync Prayer Times</button>            
            </div>
          <?php else: ?>

            <div class="pb-5">
              <h1 class="display-4 fst-italic">Subcribe a Box</h1>
              <p class="lead my-3">You have not subcribe any box.</p>

              <a class="btn btn-success" href='subscribe_box.php' id="subscribeBoxBtn">Select Subscription</a>

            </div>

          <?php endif; ?>


        <?php else: ?>

          <h1 class="display-4 fst-italic">Title of a Time to Pray Application</h1>
          <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently
          about what’s most interesting in this post’s contents.</p>

        <?php endif; ?>

      </div>
    </div>
  </div>

