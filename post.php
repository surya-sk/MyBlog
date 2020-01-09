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
  <title>My Posts</title>

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
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addPost.php">addPost</a>
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
        <h1 class="mt-4">
          <?php
          $varName = $_GET['title']; //gets the title via the query string
          echo "$varName";
          $url = basename($_SERVER['REQUEST_URI']);
  
         
          ?>
        </h1>

        <!-- Author -->
        <!--'p' is the paragraph tag. It is used to display text-->
        <p class="lead">
          by
          <!--gets the author via the query string-->
          <a href="about.php"><?php echo $_GET['user'];?></a>
        </p>

        <hr>

   
      <?php
      $postID = $_GET['postID'];
      $userID = $_SESSION["userID"];
      
          $sql = "SELECT  posts.PostID, posts.Post, posts.Title, posts.ImageFName, posts.Date FROM posts WHERE postID=$postID";
          $result = mysqli_query($conn, $sql); //sending a query to the database
  
             if (mysqli_num_rows($result) > 0)
              {
                 
                 while($row = mysqli_fetch_assoc($result)) 
                 {
                    $postID = $row["PostID"];
                     $text = $row["Post"];
                     $imageFile = $row["ImageFName"];
                     $title = $row["Title"];
                     $timeStamp = $row["Date"];
                 }
              }
        echo '<p>'.$timeStamp.'</p>

        <hr>
       
       <img class="img-fluid rounded" src="Files/'.$imageFile. '" alt="image"/>
        
        <hr>

        <!-- Post Content -->
        <p>'.
          $text.'
          
        </p>

        <hr>';

       //<!-- Comments Form-->
      echo  '<div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            
            <form method="post" action="'.$url.'">';
            date_default_timezone_get('America/Halifax');
              
            //validates the comment
              if(isset($_POST['formSubmit']))
              {
                if($_POST['formSubmit']=='submit')
                {
                  $varComment = $_POST['comm'];
                  $errorMessage = "";
                  if(empty($_POST['comm']))
                  {
                    $errorMessage.="<li>You didn't enter a comment<li>";
                  }
                  if(!empty($errorMessage))
                  {
                    echo("<p>There was an error with your comment.");
                    echo("<ul".$errorMessage."</ul>\n");
                  }
                
                  else
                  {
                    $date = date_create();//creates a date
                    $datString = date_timestamp_get($date);//creates a timestamp for the date
                    $formatDate = date("Y-m-d H:i:s", time())."\n"; //converts the timestamp into a readable format
                   $sqlc = "INSERT INTO comments(PostID,UserID,Comment) VALUES (?,?,?)"; //adds comment to database
                   if($stmt = mysqli_prepare($conn, $sqlc)) //using prepared statement
                    {
                      mysqli_stmt_bind_param($stmt, "iis", $postID,$userID,$varComment);
                    }
                    if(mysqli_stmt_execute($stmt))
                    {
                      echo "Comment added successfully";
                    } 
                   else
                    {
                    echo "Error: " . $sqlc . "<br>" . mysqli_error($conn);
                    }
                  }
                }
              }
            
          echo '<div class="form-group">
                <input type = "text" name= "comm" class="form-control" rows="3"/><input type="hidden" title="name" value="$name"/>
              </div>
              <button type="submit" name="formSubmit" value="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>';

     
            $sql2 = "SELECT comments.Comment, comments.UserID, comments.Date FROM comments WHERE postID=$postID ORDER BY comments.Date DESC";
            $result2 = mysqli_query($conn, $sql2); //sending a query to the database
            if (mysqli_num_rows($result2) > 0)
            {  
               while($row = mysqli_fetch_assoc($result2)) 
               {
                $userTuple = $row['UserID'];
                $sqlt = "SELECT Name FROM users WHERE userID= $userTuple";
                $resultt = mysqli_query($conn,$sqlt);
                $userRow = mysqli_fetch_assoc($resultt);
                $user = $userRow["Name"];
                echo  '<!-- Single Comment -->
                <div class="media mb-4">
                  <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                  <div class="media-body">
                    <h5 class="mt-0">'.$user.' ('. $row['Date'].')</h5>';
                  echo $row['Comment'];
                  echo '</div>
                </div>';
               }
            }  
     echo '</div>';
     mysqli_close($conn); //closing connection  
      ?>

     
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