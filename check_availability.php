<?php 
require_once("includes/config.php");
if(!empty($_POST["email"])) {
    $email = $_POST["email"];
    
    // Выполнение запроса для проверки существования email в базе данных
    $result = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
    $count = mysqli_num_rows($result);
    
    if($count > 0) {
        // Если email уже существует
        echo "<span style='color:red'> Email уже существует.</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    } else {
        // Если email доступен для регистрации
        echo "<span style='color:green'> Email доступен для регистрации.</span>";
        echo "<script>$('#submit').prop('disabled', false);</script>";
    }
}
?>
