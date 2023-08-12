<!--- LAST UPDATE 13 OCT -->

<html>
<head>
    <title> Processing... </title>

    <!--- STYLESHEET HREF -->
    <link rel="icon" type="image/x-icon" href="../image/logo_5px.png">
    <link rel="stylesheet" type="text/css" href="../style/homepage.css"/>

</head>

<body>
      <!--- Loading -->
    <div id="load-box">
        <img src="../image/loader_1.svg" id="loader-1"/>
    </div> 
</body>
</html>

<?php
// Continue the session
session_start();

// check if form submitted
if
    (
    isset($_POST['f-revoke-all-priv']) &&
    isset($_POST['f-cur-username-for-revoke-all-priv']) &&
    isset($_POST['f-cur-hostname-for-revoke-all-priv'])
    )
{   
    $_SESSION['s-cur-user'] = $_POST['f-cur-username-for-revoke-all-priv'];
    $_SESSION['s-cur-host'] = $_POST['f-cur-hostname-for-revoke-all-priv'];

    if 
       (
        // check is login session var set
        isset($_SESSION['s-username']) &&
        isset($_SESSION['s-hostname']) &&
        isset($_SESSION['s-password'])
       )
       {
        // validate and save in local variable
        $username = validate($_SESSION['s-username']);
        $hostname = validate($_SESSION['s-hostname']);
        $password = validate($_SESSION['s-password']); 
    
        $curr_username = $_SESSION['s-cur-user'];
        $curr_hostname = $_SESSION['s-cur-host'];

        // call function 
        all_priv_revoke($hostname, $username, $password, $curr_username, $curr_hostname);
       }
}
else {
    // alert and redirect to logn page if someone try to direclt access
    echo "<script> 
    alert('Do not direct access page'); 
    location.href='../index.php';
    </script>";
    // destroy the session
    session_destroy();
}


// This function will remove impurities from form input
function validate($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



function  all_priv_revoke($hostname, $username, $password, $curr_username, $curr_hostname) {
    try {
        // establish connection
        $con = new mysqli($hostname, $username, $password);

        // Query
        $sql = "REVOKE ALL ON *.* FROM " . "'" . $curr_username . "'" . "@" . "'" .  $curr_hostname . "'" . ";";
        // run query
        try {
            $con->query($sql);
            // set SESSION variable with success status msg
            $_SESSION['s-r-a-p-status'] = "done";
          
            // unset data recieved
            unset($_SESSION['s-cur-user']);
            unset($_SESSION['s-cur-host']);

            // redirect to homepage
            echo "<script> location.href='privileges.php'; </script>";
        }
        catch(EXCEPTION $erro) {
            $errorMsg = $erro->getMessage();
          
            // set SESSION variable with NOT success status msg
            $_SESSION['s-r-a-p-status'] = "failed";
            $_SESSION['s-r-a-p-msg'] = $errorMsg;
          
            // unset data recieved
            unset($_SESSION['s-cur-user']);
            unset($_SESSION['s-cur-host']);

            // redirect to homepage
            echo "<script> location.href='privileges.php'; </script>";
        }
        $con->close();
    }
    catch(EXCEPTION $err) {
        $errMsg = $err->getMessage();
        echo "<script> console.log('{$errMsg}'); </scritp>";
    }
}
?>

<script>
     if(!navigator.onLine) {
       alert("Ohh you're not connected to the Internet!");
       location.href="../";
     }
</script>

<noscript> 
        <div 
        style="position: fixed; top: 0; left:0; width:100%; height: 100vh; 
        background-color: rgb(255, 255, 255); z-index: 2000;
        display: flex; justify-content:center; align-items: center;">
        <h1 style="background-color: rgb(246, 167, 167); border-radius: 10px; padding: 10px; font-size: 30px;"> Please Enable Your Browser's Javascript Engine! </h1>
        </div>
</noscript>