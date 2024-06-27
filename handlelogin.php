<?php
 error_reporting(0); //this is to block unneccasry warnings when the code is working
$showerror="false";
if($_SERVER["REQUEST_METHOD"]== "POST"){
     include 'dbconnect.php';
     $email= $_POST['loginemail'];
     $pass= $_POST['loginpassword'];
     $sql="Select * from `users` where user_email='$email'";
     $result= mysqli_query($conn,$sql);
     $numrows=mysqli_num_rows($result);
          if($numrows==1){
                  $row= mysqli_fetch_assoc($result);
                    if(password_verify($pass ,$row['user_pass'])){
                      session_start();
                      $_SESSION['loggedin'] =true;
                      $_SESSION['sno'] =$row['sno'];
                      $_SESSION['useremail'] =$email;  //session being set
                      header("location:/forum/index.php?loginsuccess=true");
                    }
                    else{
                      header("location:/forum/index.php?loginsuccess=false&error==$showerror");
                             echo "unable to login (usual error = wrong password)";
                            //now working :-]
                    }
                    //header("location:/forum/index.php?loginsuccess=true");
                   }
          //if user enters incorrect pass then the error alert will show otherwise on incorrect
          //password it will leads to handlelogin blank page.
}









?>