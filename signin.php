<?php
  session_start(); //statring the session
  include_once 'login.php';
  if($_GET['loggedin']==1)
  {
    $_SESSION["loggedin"] = false;
  }
  ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!--Gives title to the webpage that is not displayed in the webpage-->
  <title>Sign-in</title>

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
        <h1 class="mt-4">Sign-in</h1>
        <p>If you have an account, sign-in to your account</p>
        <form method = "post" action = "signin.php">
          <div class="form-group">
            <p>Username</p>
            <input type="name" class="form-control" name="username" placeholder="Enter username">
          </div>
           <div class="form-group">
            <p>Password</p>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
          </div>
          <button type="submit" name = "formSubmit" class="btn btn-primary" value = "Submit">Submit</button>
        </form>
        <?php
          $username = $_POST['username'];
          $password = $_POST['password'];

          if($_POST['formSubmit'] == "Submit")
          {
             if(empty($username)) 
             {
               echo "Username is required. ";
             }
             if(empty($password))
             {
               echo "Password is required.";
             } 
 
             else
             {
              $sql = "SELECT username, password, UserID FROM login WHERE username = '$username'"; //sending a query to the database
              $query = mysqli_query($conn, $sql);
              $row = mysqli_fetch_assoc($query);
              if(mysqli_num_rows($query) == 0)
              {
                echo "Username does not exist.";
              }
              
              else
              {
                if($password == $row['password'])
               {
                 header("location: index.php");
                 echo $_SESSION["userID"];
                 echo "Success";
                 $_SESSION["loggedin"] = true;
                 $_SESSION["userID"] = $row['UserID'];
               }
               else
               {
                 echo "The password you have entered is incorrect.";
                 //header("location: signin.php");
                 $_SESSION["loggedin"] = false;
               }
              }
             }
            
          }
        
          mysqli_close($conn); //closing connection  
          
          ?>
      </div>
    </div>

      <br>
      <br>

      <div class="form-group">
        <p>Don't have an account? Create here.<p>
        <a href = "account.php" type = "create" class ="btn btn-primary">Create Account</a>
    </div>

    </div>
    <!-- /.row -->

    
  
  </div>

 
    
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
