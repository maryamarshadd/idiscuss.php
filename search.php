<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Welcome to iDISCUSS-Coding Forum
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<style>
    .container{
        min-height: 100vh;
    }
</style>
    </head>

<body>
<?php include 'partials/dbconnect.php'; ?>
    <?php include 'partials/header.php'; ?>
    <?php
        /*$thread_user_id = $row['thread_user_id'];
        $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by= $row2['user_email'];*/
  
?>
   
  <!-- search results start here -->
  <div class="container my-3">
    <h2>Search results for "<em><?php echo $_GET['search']?></em>"</h2>
<?php
$noresults=true;
$query=$_GET['search'];
 $id= $_GET['threadid'];
 $sql = "SELECT * FROM threads WHERE MATCH(thread_title , thread_desc) against('$query')";
 $result = mysqli_query($conn,$sql);
  while($row= mysqli_fetch_assoc($result)){
     $title= $row['thread_title'];
     $desc= $row['thread_desc'];
     $id= $row['thread_id'];
     $url="thread.php?threadid=".$id;
     $noresults=false;
     echo'<div class="result">
     <h3> <a href="'.$url.'" class="text-dark">'.$title.' </a></h3>
     <p>'.$desc.'</p>
     </div>';
  }
  if($noresults){
    echo' <div class="jumbotron jumbotron-fluid">
    <div class="container">
    <p class= "display-4 text-center">No Results Found</p>
    <p class="lead">Suggestions:<ul>
    <li>Make sure that all words are spelled correctly.</li>
    <li>Try different keywords.</li>
    <li>Try more general keywords. </li><ul></p>
    </div>
    </div>';
  }
  ?>
  </div>
         
            <?php include 'partials/footer.php'
 ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
                integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
                crossorigin="anonymous"></script>
</body>
</html>