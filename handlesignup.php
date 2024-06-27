<?php
$showerror="false";
if($_SERVER["REQUEST_METHOD"] =="POST"){
include 'dbconnect.php';
$user_email= $_POST['signupemail'];         //this is coming from form we made in signup file 
$pass= $_POST['signuppassword'];  
$cpass= $_POST['signupcpassword'];
//check whether the email types already exists
$existsql="select * from `users` where user_email='$user_email'";
$result= mysqli_query($conn,$existsql);
$numrows= mysqli_num_rows($result);
if($numrows>0){
    $showerror ="email already in use";
}
else{
    if($pass == $cpass){
                 $hash= password_hash($pass, PASSWORD_DEFAULT); //to secure database if it gets invaded so hacker must not know the actual password despite of knowing the email lol
                 $sql="INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) 
                 VALUES ('$user_email', '$hash', current_timestamp())";
                 $result= mysqli_query($conn,$sql);
                 if($result){
                    $showalert=true;
                    header("location:/forum/index.php?signupsuccess=true");   //redirects to actual page also can be seen in urls
                    exit();
                }
    }
    else{
        $showerror="passwords donot match";
        header("location:/forum/index.php?signupsuccess=false&error=$showerror");
    }

     }
}

?>