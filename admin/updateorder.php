<?php
session_start();
include_once 'include/config.php';

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $oid = intval($_GET['oid']);

    if (isset($_POST['submit2'])) {
        $status = $_POST['status'];
        $remark = $_POST['remark']; // комментарий

        // Добавление записи в историю отслеживания заказа
        $query = mysqli_query($con, "INSERT INTO ordertrackhistory (orderId, status, remark) VALUES ('$oid', '$status', '$remark')");
        // Обновление статуса заказа
        $sql = mysqli_query($con, "UPDATE orders SET orderStatus='$status' WHERE id='$oid'");
        echo "<script>alert('Заказ успешно обновлен...');</script>";
    }
?>
<script language="javascript" type="text/javascript">
function closeWindow() {
    window.close();
}
function printPage() {
    window.print();
}
</script>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Обновление заказа</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f7;
            color: #333;
        }
        .container {
            margin: 50px auto;
            max-width: 700px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header-title {
            color: #6ab0f0;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .order-id {
            font-size: 18px;
            font-weight: bold;
            color: #6ab0f0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table td, .table th {
            padding: 10px 15px;
        }
        .table th {
            background-color: #6ab0f0;
            color: #fff;
            text-align: left;
        }
        .status-delivered {
            color: #28a745;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .btn {
            background-color: #6ab0f0;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #004494;
        }
        .btn-close {
            background-color: #6c757d;
        }
        .btn-close:hover {
            background-color: #5a6268;
        }
        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header-title">Обновление заказа</div>
    <form name="updateticket" id="updateticket" method="post"> 
        <table class="table">
            <tr>
                <th>ID заказа:</th>
                <td class="order-id"><?php echo $oid; ?></td>
            </tr>
            <?php 
            $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>
            <tr>
                <th>Дата:</th>
                <td><?php echo $row['postingDate']; ?></td>
            </tr>
            <tr>
                <th>Статус:</th>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <tr>
                <th>Комментарий:</th>
                <td><?php echo $row['remark']; ?></td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <?php } ?>

            <?php 
            $st = 'Delivered';
            $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
            while ($num = mysqli_fetch_array($rt)) {
                $currentSt = $num['orderStatus'];
            }
            if ($st == $currentSt) { ?>
            <tr>
                <td colspan="2" class="status-delivered">Продукт доставлен</td>
            </tr>
            <?php } else { ?>
            <tr class="form-group">
                <td>Статус:</td>
                <td>
                    <select name="status" required="required">
                        <option value="">Выберите статус</option>
                        <option value="В процессе">В процессе</option>
                        <option value="Доставлен">Доставлен</option>
                    </select>
                </td>
            </tr>
            <tr class="form-group">
                <td>Комментарий:</td>
                <td>
                    <textarea cols="50" rows="7" name="remark" required="required"></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="submit2" value="Обновить" class="btn" />
                    <input name="Submit2" type="button" class="btn btn-close" value="Закрыть это окно" onClick="closeWindow();" />
                </td>
            </tr>
            <?php } ?>
        </table>
    </form>
</div>
</body>
</html>
<?php } ?>
