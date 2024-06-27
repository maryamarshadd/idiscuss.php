<?php
session_start();
echo '<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">iDISCUSS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="contact.php" >Contact</a>
      </li>
    </ul>
    <div class="mx-2">';
 //when login and signup button will display and when logout button will display
 //----------------------------------------------------------------------------
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
echo'<form class="d-flex" role="search" method="get" action="search.php">
<button class="btn btn-outline-success mx-2" type="submit">Search</button>
<input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
<p class="text-light my-1 mx-3">"<em>Welcome</em>|<b>'.$_SESSION['useremail'].  '|</b>" </p> 
<a href="partials/logout.php" class="btn btn-success"> Logout </a>
</form>'; 
    }
else{
  echo'<button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#loginModal"> Login </button>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#signupModal"> Signup </button>
    </div>
    <form class="d-flex" role="search">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>';
     }
//------------------------------------------------------------------------------------

  echo '</div>
</div>
</nav>';
include 'partials/login.php' ;
include 'partials/signup.php' ;
include 'partials/handlelogin.php' ;
//alerts for login and signup successes and failures
//-----------------------------------------------------------------------------------
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo' <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
               <strong>SUCCESS!</strong> You can now Login.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  echo' <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
               <strong>FAILED!</strong> Please type same passwords
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
} 
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="true"){
  echo' <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
               <strong>SUCCESS!</strong> You are logged in.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}   
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false"){
  echo' <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
               <strong>FAILED!</strong> Make sure to enter correct password.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
 if(isset($_GET['logout']) && $_GET['logout']=="true"){
  echo' <div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
               <strong>Logged out!</strong> You have been logged out.
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}  
//-------------------------------------------------------------------------------------------     
/*to show categories of you saved in database:
$sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
      $result = mysqli_query($conn, $sql); 
      while($row = mysqli_fetch_assoc($result)){
        echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id']. '">' . $row['category_name']. '</a>'; 
      }
      for this you must add dbconnect to top of every file in roder to make 
      this work in every web page*/



?>