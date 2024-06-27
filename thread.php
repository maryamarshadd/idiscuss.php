<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Welcome to iDISCUSS-Coding Forum</title>
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/dbconnect.php'; ?>
    <?php
    $id= $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn,$sql);
     while($row= mysqli_fetch_assoc($result)){
        $title= $row['thread_title'];
        $desc= $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by= $row2['user_email'];
  
}?>
<!-------------------------------------------------------------------------------------------------------->
<?php 
$showAlert =false;
//--this code helps to let end user upload or post any comments that will be saved into database as they enter------
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST'){
    $showAlert = true;
    //inserting into db threads
    $comment = $_POST['comments'];  //it is the table name we are saving our end users data into []
    $comment= str_replace("<","&lt;",$comment); //this is for security, if anyone tries to invade
    // web by writing html in comments and getting it runs then we must catch their text before they get their hands on our web
    $comment= str_replace(">", "&gt;",$comment);
    $sno = $_POST['sno'];
   $sql= "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`)
     VALUES ('$comment', '$id', '$sno', current_timestamp());";  //removing commentid as it is auto incremented
    $result = mysqli_query($conn,$sql);
   //an alert that will be shown at the top of web: 
 if($showAlert){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUCCESS!</strong> Your comment has been added.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
?>
<!-------------------------------------------------------------------------------------------------------->
    <div class="container my-4">
        <div class="jumbotron">
            <h2 class="display-4 text-center"><?php echo $title;?></h2>
            <p class="lead py-2"> <?php echo $desc;?></p>
            <hr class="my-4">
            <p>DISCLAIMER: This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed.
                Do not post copyright-infringing material. Do not post “offensive” posts,
                links or images. Do not cross post questions. Remain respectful of other members at all times.</p>
            <p><b>Posted by: </b><em><?php echo  $posted_by; ?></em></p>
            <!--<a class="btn btn-primary btn-lg" href='#' role="button"> Learn More</a>
             echo $posted_by; -->
        </div>
    </div>
    <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
    <h1 class="py-2"> Post a Comment </h1>
    <form action= "'. $_SERVER['REQUEST_URI'].'" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your Comment</label>
            <textarea class="form-control" id="comments" name="comments" rows="3"></textarea> <br>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'"> 
            <button type="submit" class="btn btn-success">Post comment</button>
    </form>
</div>';}
        else{
            echo'<h1 class="py-2"> Post a Comment </h1>
            <div class="alert alert-dark" role="alert">
           <p class="lead text-center"> You are not logged in Yet! Please login to enable comments on <em>iDISCUSS</em>.</p>
          </div>';
        }
        ?>
    <?php include 'partials/dbconnect.php'; ?>
    <br> 
<!-----------this is used to display,save,add comment entries into database also to display on website-------------->
    <div class="container" id="ques">
        <h1 class="py-2"> Discussions </h1>
        <?php
    $id= $_GET['threadid'];          //this helps to fetch tht correct url
    $sql = "SELECT * FROM `comments` WHERE thread_id= $id";
   $result = mysqli_query($conn,$sql);
   $noresult=true;
       while($row = mysqli_fetch_assoc($result)){
        $noresult=false;
           $id =  $row['comment_id'];
           $time = $row['comment_time'];  
            $content = $row['comment_content'];          //names saved in database are written here 
            $thread_user_id= $row['comment_by'];
            $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
      
            echo '<div class ="media my-3">
       <img src ="img/userdefault.png" width="35px" class="mr-3" alt="loading">
       <div class= "media-body">
       <p class= "font-weight-bold my-0"><b>'. $row2['user_email']. ' | '.$time.'| </b></p>
         '. $content.'
</div>
</div>'; }  
if($noresult){    //the no comments found alert code
    echo '<button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">Toggle offcanvas</button>

    <div class="alert alert-info d-none d-lg-block"><b>NO COMMENTS FOUND</b><hr><em>Be the first one to post a comment here.</em></div>
    
    <div class="offcanvas-lg offcanvas-end" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Responsive offcanvas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
      </div>
    </div> ';
 }
     mysqli_close($conn);
     ?>
    </div>
  <!-------------------------------------------------------------------------------------------------------------> 
   
        <?php include 'partials/footer.php'?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
        </script>
</body>

</html>