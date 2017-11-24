<?php 

session_start();

if (isset($_POST['submit'])) {
    
    include 'dbh.inc.php';
    
    //Put the data in variables
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    
    //Error handlers
    //Check if the input is empty   
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            echo "Check je gebruikersnaam"
                exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                //De-hashing password
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true){
                    //Log in the user here
                    $_SESSION['u_id'] =$row['user_id'];
                    $_SESSION['u_first'] =$row['user_first'];
                    $_SESSION['u_lsat'] =$row['user_last'];
                    $_SESSION['u_email'] =$row['user_email'];
                    $_SESSION['u_uid'] =$row['user_uid'];
                    header("Location: ../index.php?login=succes");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}
