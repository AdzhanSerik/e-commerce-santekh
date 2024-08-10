<?php
session_start(); // Запуск сессии
include("includes/config.php"); // Подключение конфигурационного файла

$_SESSION['login'] == ""; // Эта строка не имеет эффекта, так как она сравнивает, а не присваивает

date_default_timezone_set('Asia/Kolkata'); // Установка временной зоны

$ldate = date('d-m-Y h:i:s A', time()); // Получение текущей даты и времени в формате "дд-мм-гггг чч:мм:сс AM/PM"

mysqli_query($con, "UPDATE userlog SET logout = '$ldate' WHERE userEmail = '".$_SESSION['login']."' ORDER BY id DESC LIMIT 1"); // Обновление времени выхода в базе данных для текущего пользователя

session_unset(); // Очистка всех переменных сессии

$_SESSION['errmsg'] = "Вы успешно вышли из аккаунта"; // Установка сообщения об успешном выходе
?>
<script language="javascript">
document.location="index.php"; // Перенаправление на страницу index.php
</script>
