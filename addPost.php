<?php
  session_start(); //statring the session
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)  //can be accessed only if user is logged in
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
          <li class="nav-item active">
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

        <!-- Title -->
        <h1 class="mt-4">Add Post</h1>
        <form method = "post" action = "addPost.php">
          <div class="form-group">
            <p>Post name</p>
            <input type="name" class="form-control" name="title" placeholder="Enter name">
          </div>
           <div class="form-group">
            <p>Your Post</p>
            <textarea type=textarea class="form-control" name="post" placeholder="Enter text"></textarea>
          </div>
          <div class="form-group">
            <p>Image name</p>
            <input type="text" class="form-control" name="ImageFName" placeholder="Enter image name">
          </div>
          <br>
          <input type="submit" class="btn btn-primary" value="Submit">
          <br>
        </form>
      </div>
    </div>

    <?php

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sql = "INSERT INTO posts(UserID, Title, Post, ImageFName) VALUES(?,?,?,?)";
        if($stmt = mysqli_prepare($conn, $sql)) //using prepared statement
        {
          mysqli_stmt_bind_param($stmt, "isss", $_SESSION["userID"],$_POST['title'],$_POST['post'], $_POST['ImageFName']);
        }
        if(mysqli_stmt_execute($stmt))
        {
          header("location: index.php");
        }
        else
        {
          echo "Something went wrong. Please try again later.";
          echo "Error: " . $sqlc . "<br>" . mysqli_error($conn);
          echo $_SESSION["userID"];
        }
        mysqli_stmt_close($stmt);
      }
      mysqli_close($conn); //closing connection  
    ?>
    

      <br>
      <br>
      <br>
      <br>
      <br>

    </div>
      

    
  
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
