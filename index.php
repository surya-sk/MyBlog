<?php
  session_start(); //statring the session
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)  //can be accessed only if user is logged in
  {
    echo "Welcome to your homepage.";
  }
  else
  {
    header("location: signin.php");
    echo "You need to be signed in to access the website.";
  }
  include_once 'functions.php'; 
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
  <title>Daily Journal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

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
          <li class="nav-item active">
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

        <!-- Blog Post -->
        
        <?php
         $userID = $_SESSION["userID"];
        $sqlt = "SELECT Name FROM users WHERE userID=$userID";
        $resultt = mysqli_query($conn,$sqlt);
        $userRow = mysqli_fetch_assoc($resultt);
        $user = $userRow["Name"];

        echo '<div class="col-md-8">

        <h1 class="my-4"> My Blog
          <a href="about.php">'.$user.'</a>
        </h1>';


         
          $sql = "SELECT  PostID, Post, Title, ImageFName, posts.Date FROM posts WHERE UserID = $userID ORDER BY posts.Date DESC"; //sending a query to the database
          $result = mysqli_query($conn, $sql);
  
             if (mysqli_num_rows($result) > 0)
              {
                 while($row = mysqli_fetch_assoc($result)) 
                 {
                   $postID = $row["PostID"];
                     $text = $row["Post"];
                     $imageFile = $row["ImageFName"];
                     $title = $row["Title"];
                     $timeStamp = $row["Date"];
                     //$formatDate = date("F jS, Y -g:ia", $timeStamp);
                     echo '<div class="card mb-4">
                     <img class="card-img-top" src="Files/'.$imageFile.'" alt="Card image cap"/>
                     <div class="card-body">';
               
                    
                       echo '<h2 class="mt-0">'. $title.'</h2>';
                     
                     getFirstThreeLines($text); //prints the first three lines
                     
               echo "<br>";
               //query string 
               echo '<a href="post.php?title='.$title.'&postID='.$postID.'&user='.$user.'" class="btn btn-primary">Read More &rarr;</a> 
                     <p>
                     </div>
                     <div class="card-footer text-muted">'.
                     $timeStamp. " by ".
                     '<a href="about.php">'.$user.'</a>
                     </div>
                     </div>';
                
                 }
             }
             else
             {
               echo "You have no posts. You can add a post by clicking on 'Add Post' from the navigation bar.";
             } 
             
         mysqli_close($conn); //closing connection  
        ?>
      </div>

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
             <!-- Log Out Widget -->
        <div class="card my-4">
          <h5 class="card-header">Log Out</h5>
          <div class="card-body">
            Log out of your account
          </div>
          <?php 
          echo '<a href="signin.php?loggedin=1" class="btn btn-primary">Log Out</a>';
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