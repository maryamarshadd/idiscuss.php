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
//-----------------------------------------------------------------------------------
//this for categories being displayed on web and also being saved on phpmyadmin(database)
    $id= $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id='$id'";
    $result = mysqli_query($conn,$sql);
     while($row= mysqli_fetch_assoc($result)){
        $catname= $row['category_name'];
        $catdesc= $row['category_description'];
} //------------------------------------------------------------------------------------------
?>
    <?php 
$showAlert =false;
//------------------------------------------------------------------------------------------------
//this code is allowing us to submit our request to database(table) so that it can be saved
//method type is imp, connection before that to database is v imp means a seperate file for it.
//it will display question and its description on anys page we would be on the website.
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST'){
    $showAlert = true;
    //inserting into db threads
    $th_title = $_POST['title'];
    $th_desc = $_POST['desc'];
    $th_title= str_replace("<","&lt;",$th_title); //this is for security, if anyone tries to invade
    // web by writing html in comments and getting it run then we must catch their text before they get their hands on our web
    $th_desc= str_replace(">", "&gt;",$th_desc);
    $th_desc= str_replace("<","&lt;",$th_desc); //one for title and one for desc
    $th_title= str_replace(">", "&gt;",$th_title);
    $sno = $_POST['sno'];
    $sql= "INSERT INTO `threads`(`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, 
    `timestamp`) VALUES ('$th_title', '$th_desc', '$id','$sno', current_timestamp())";
    $result = mysqli_query($conn,$sql);
 //an error that repeats everytime : when making primary key make sure to makw it not null AUTO INCREMENT 
 //so that you ll be able to add and inseert more than once
 if($showAlert){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUCCESS!</strong> Your Thread has been added,Please wait for community to respond.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
?>
    <!--this is used to display every categories name on front when we click on it from mmain website page
and else is randon text being displayed beneath it like disclaimer-->
    <div class="container my-4">
        <div class="jumbotron">
            <h2 class="display-4 text-center">Welcome to <?php echo $catname;?> forums</h2>
            <p class="lead py-2"> <?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>DISCLAIMER:This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not
                allowed.
                Do not post copyright-infringing material. Do not post “offensive” posts,
                links or images. Do not cross post questions. Remain respectful of other members at all times.</p>
            <p>Posted by: <em></em></p>
            <!--<a class="btn btn-primary btn-lg" href='#' role="button"> Learn More</a>
             echo $posted_by; -->
        </div>
    </div>
    <!--------------------this is a form to make an interface on web----------------------->
    <?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
echo '<div class="container">
        <h1 class="py-2"> Start a Discussion </h1>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title short.</div>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'"> 
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea> <br>
                <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
    <br> <br>
    <hr> <br> <br>';}
    else{
        echo'<h1 class="py-2"> Start a Discussion </h1>
        <div class="alert alert-dark" role="alert">
       <p class="lead text-center"> You are not logged in Yet! Please login to start discussion on <em>iDISCUSS</em>.</p>
      </div>';
    }
    ?>
    <?php include 'partials/dbconnect.php'; ?>

    <!-------------for the connection of threads so that it can be saved on database  ---------------->
    <div class="container" id="ques">
        <h1 class="py-2"> Browse Questions </h1>
        <?php
    $id= $_GET['catid'];
    $sql = "SELECT * FROM `threads` WHERE thread_cat_id= '$id'";
   $result = mysqli_query($conn,$sql);
   $noresult=true;
       while($row = mysqli_fetch_assoc($result)){
         $noresult=false;
           $id =  $row['thread_id'];
            $title = $row['thread_title'];   
            $desc = $row['thread_desc'];
            $thread_time= $row['timestamp'];
            $thread_user_id= $row['thread_user_id'];
            $sql2= "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
       echo '<div class ="media my-3">
       <img src ="img/userdefault.png" width="34px" class="mr-3" alt="loading">
       <div class= "media-body py-1">
       <p class= "font-weight-bold my-0"><b>'. $row2['user_email'] . '  | '. $thread_time .'| </b></p>
       <h5 class "mt-0"> <a href="thread.php?threadid=' . $id . '">' . $title .' <a/> </h5>
       '. $desc.'       
     <hr>
</div>
</div>';
 }
//----------------and if a category doesnt have any thread if statement will let user know this-----------
 if($noresult){
    echo '<button class="btn btn-sucesss d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">Toggle offcanvas</button>

    <div class="alert alert-info d-none d-lg-block"><b>NO THREADS FOUND</b><hr><em>Be the first one to ask questions here.</em></div>
    
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
    <!----------this is bootstrap code to build the basics and footer connection should always be on downwards to
maintain the good display---------------->
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