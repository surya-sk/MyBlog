<?php
  session_start(); //statring the session
  include_once 'login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--Gives title to the webpage that is not displayed in the webpage-->
  <title>Contact</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">
</head>

<body>

  <!-- Navigation -->
  <!--Creates a navigation menu--> 
  <!-- 'class' helps group elements and style them all together-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <!--'div' is a division that has elements in a webpage. The elements inside a div are placed close to each other and belong to the division.-->
    <div class="container">
      <!--'a' is the anchor tag. It is usually used to store links-->
      <a class="navbar-brand" href="index.php">Daily Journal</a>
       <!--creates a button-->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <!-- 'ul' is an unordered list. It's used to list items in a navigation menu-->
        <ul class="navbar-nav ml-auto">
          <!--'li' is list. It adds items in the form a list-->
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addPost.php">Add Post</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="signin.php">Sign-in</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">Create Account</h1>
        <form method = "post" action = "account.php">
          <div class="form-group">
            <p>Your name</p>
            <input type="name" class="form-control" name="name" placeholder="Enter name">
          </div>
           <div class="form-group">
            <p>Tell us about you</p>
            <textarea type=textarea class="form-control" name="profile" placeholder="Enter text"></textarea>
          </div>
          <div class="form-group">
            <p>Image name</p>
            <input type="text" class="form-control" name="ImageFName" placeholder="Enter image name">
          </div>
          <br>
          <h2>Create a Username and Password<h2>
          <div class="form-group">
            <h5>Enter username</h5>
            <input type="username" class="form-control" name="username" placeholder="Enter username">
          </div>
          <div class="form-group">
            <h5>Enter password</h5>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
          </div>
          <button type="submit" class="btn btn-primary" name = "createAccount" value = "Submit">Submit</button>
          <br>
          <?php
             $name = $_POST['name'];
             $profile = $_POST['profile'];
             $ImageFName = $_POST['ImageFName'];
             $username = $_POST['username'];
             $password = $_POST['password'];
  
             if($_POST['createAccount'] == "Submit")
             {
                if(empty($name)) 
                {
                  echo "Enter your name. ";
                }
                if(empty($profile))
                {
                  echo "Enter description. ";
                } 
                if(empty($ImageFName))
                {
                  echo "Enter image name. ";
                } 
                if(empty($username)) 
                {
                  echo "Username is required. ";
                }
                if(empty($password))
                {
                  echo "Password is required.";
                } 
                
              $check_user = "SELECT * FROM login WHERE username='$username'"; 
              $result = mysqli_query($conn, $check_user); //sending a query to the database
              $user = mysqli_fetch_assoc($result);
              if($user)
              {
                if($user['username']==$username)
                {
                  echo "Username already exists. Please try again. ";
                }
              }
              if(strlen($password)<7) 
              {
                echo "Password must be at least 7 characters long. ";
              }

              if(!preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$", $password, $matches))
              {
                  echo "Password must have at least one uppercase letter and one number. ";
              }
              
              else
              {
                $sql = "INSERT INTO users(Name, Profile, ImageFName) VALUES(?,?,?)";
                if($stmt = mysqli_prepare($conn, $sql))
                {
                  mysqli_stmt_bind_param($stmt, "sss", $name, $profile, $ImageFName);
                }
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $userID = mysqli_insert_id($conn);
                $_SESSION["userID"] = $userID;
                $sql2 = "INSERT INTO login(UserID, username, password) VALUES(?,?,?)";
                if($stmt2 = mysqli_prepare($conn, $sql2))
                {
                  mysqli_stmt_bind_param($stmt2, "iss", $userID, $username, $password);
                }
                if(mysqli_stmt_execute($stmt2))
                {
                  echo "Account created. Redirecting to signin page";
                  echo $userID;
                  header("location: signin.php");
                }
                else
                {
                  echo "Something went wrong. Please try again later.";
                  header("location: account.php?");
                  //echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                }
              }
            }
            mysqli_close($conn); //closing connection  
          ?>
        </form>
      </div>
    </div>

      <br>
      <br>
      <br>
      <br>
      <br>

    </div>
    <!-- /.row -->

    
  
  </div>

 <!--Create Account--> 
    
  <!-- /.container -->

  <!-- Footer -->
  <!--footer is the part of the webpage that is present at the very bottom.-->
  <footer class="py-5 bg-dark">
    <div class="container">
      <!--'p' is the paragraph tag. It is used to display text-->
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
   <!-- 'script' tag links javascript files to the webpage. It is placed at the very end to enable all the elements of the page to load before the js file-->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>
