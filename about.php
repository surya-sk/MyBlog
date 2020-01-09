<?php
  session_start();
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
  {
    echo "";
  }
  else
  {
    header("location: signin.php");
    echo "You need to be signed in to access the website.";
  } 
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
  <title>About us</title>

  <!-- Bootstrap core CSS
       Links the CSS file -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">

</head>
<?php include_once 'login.php'; ?>
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
          <li class="nav-item active">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addPost.php">Add Post</a>
          </li>
          <li class="nav-item">
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
      
      <?php 
      if(!empty($_GET))
      {
        $userID = $_GET['userRow'];
      }
      else
      {
        $userID = $_SESSION["userID"];
      }
      $sql = "SELECT Name, Profile, ImageFName FROM users where UserID = $userID";
      $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0)
          {
             
             while($row = mysqli_fetch_assoc($result)) 
             {
                 $name = $row["Name"];
                 $imageFile = $row["ImageFName"];
                 $profile = $row["Profile"];
             }
          }
        echo '<!-- Title -->
        <h1 class="mt-4">About Me</h1>

        <!-- Preview Image -->';
        //<!--'img' tag is used when there's a need to show images on the webpage, either from the local machine or from a URL-->
        echo '<img class="img-fluid rounded" src="Files/'.$imageFile.'" alt="">

        <hr>';

        //<!-- Post Content -->
        //<!--'p' is the paragraph tag. It is used to display text-->
        echo '<p class="lead">'.
        $profile.'
          
        </p>';
      ?>  
        <hr>
      </div>

      <!-- Sidebar Widgets Column -->
       <!-- Sidebar Widgets Column -->
       <div class="col-md-4">

<!-- Search Widget -->
<div class="card my-4">
  <h5 class="card-header">Search</h5>
  <div class="card-body">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-secondary" type="button">Go!</button>
      </span>
    </div>
  </div>
</div>



<!-- Categories Widget -->
<div class="card my-4">
  <h5 class="card-header">Categories</h5>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-6">
        <ul class="list-unstyled mb-0">
          <li>
            <a href="#">Web Design</a>
          </li>
          <li>
            <a href="#">HTML</a>
          </li>
          <li>
            <a href="#">Freebies</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-6">
        <ul class="list-unstyled mb-0">
          <li>
            <a href="#">JavaScript</a>
          </li>
          <li>
            <a href="#">CSS</a>
          </li>
          <li>
            <a href="#">Tutorials</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  </div>
     <!-- Side Widget -->
<div class="card my-4">
  <h5 class="card-header">Log Out</h5>
  <div class="card-body">
    Log out of your account
  </div>
  <?php 
  echo '<a href="signin.php?loggedin=1" class="btn btn-primary">Log Out</a>'
  ?>

</div>



</div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <!--footer is the part of the webpage that is present at the very bottom.-->
  <footer class="py-5 bg-dark">
    <div class="container">
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
