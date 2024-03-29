<!--- LAST UPDATE 11 OCT -->

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
if(
    isset($_POST['f-priv_cur_user']) &&
    isset($_POST['f-priv_cur_host'])
    ) {
   
    // store in SESSION variable via POST variable
    $_SESSION['s-priv_cur_user'] = $_POST['f-priv_cur_user'];
    $_SESSION['s-priv_cur_host'] = $_POST['f-priv_cur_host'];

    // redirect to privileges.php and let that page show privileges of current user-account
    echo "<script> 
    location.href='privileges.php';
    </script>";

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