<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />


  <title>Sign in & Sign up Form</title>
  <?php
  session_start();
  if (isset($_SESSION['login_id']))
    header("location:index.php?page=home");
  ?>
  <link rel="stylesheet" href="./resources/font-awesome/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="./resources/css/loginStyles.css" />
  <style>
    .toast{
  display: none;
  min-width: 20vw
}
.toast.show {
    display: block;
    opacity: 1;
    position: fixed;
    z-index: 99999999;
    margin: 20px;
    left: 0;
    top: 3.5rem;
}
  </style>
</head>

<body>
<div class="toast bg-success" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
</div>
  <main id="main" class="alert-info">
    <div class="container">
      <div class="forms-container">
        <div class="">
          <form id="login-form" class=" sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" />
            </div>
            <button class="btn solid">Login</button>
            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <form action="#" id="signup-form" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" name="username" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" placeholder="name" name="name" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" />
            </div>
            <button class="btn solid">Sign Up</button>
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Sign Up for free and manage, access and share file
              on the go like never before. Now you can chat with your friends and see if they are online!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="./resources/img/rocket.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Welcome Back! This is a mini project made by ["SHITENDU MISHRA"]
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="./resources/img/rocket.svg" class="image" alt="" />
        </div>
      </div>
    </div>
  </main>
  <script src="./resources/jquery/jquery.min.js"></script>
  <script src="./resources/jquery/app.js"></script>
  <script>
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    $('#login-form').submit(function (e) {
      e.preventDefault()
      $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
      if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url: '/workstation/includes/actionDispatcher.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

        },
        success: function (resp) {
          if (resp == 1) {
            location.reload('index.php?page=files');
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
            $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
          }
        }
      })
    })





    $('#signup-form').submit(function (e) {
      e.preventDefault()
      $('#signup button[type="button"]').attr('disabled', true).html('Logging in...');
      if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url: '/workstation/includes/actionDispatcher.php?action=signup',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
          console.log(err)
          $('#signup-form button[type="button"]').removeAttr('disabled').html('Login');

        },
        success: function (resp) {
          if (resp) {
            document.getElementsByClassName("signup-form")[0].reset();
            $('#alert_toast .toast-body').html("Signed Up Secessfully!")
            $('#alert_toast').toast({delay:3000}).toast('show');
            
          } else {
            $('#signup-form').prepend('<div class="alert alert-danger">Error Occured.</div>')
            $('#signup-form button[type="button"]').removeAttr('disabled').html('Login');
          }
        }
      })
    })
  </script>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</body>

</html>