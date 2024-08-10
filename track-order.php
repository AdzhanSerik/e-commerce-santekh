<?php
session_start();
include_once 'includes/config.php';
$oid = intval($_GET['oid']);
?>
<script language="javascript" type="text/javascript">
function f2() {
    window.close();
}

function f3() {
    window.print(); 
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Детали отслеживания заказа</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f4f7;
        color: #333;
    }
    .container {
        margin-top: 50px;
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
    .table td {
        padding: 10px 15px;
    }
    .table th {
        background-color: #6ab0f0;
        color: #fff;
        padding: 10px 15px;
    }
    .status-delivered {
        color: #28a745;
        font-weight: bold;
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
    <div class="header-title">Детали отслеживания заказа</div>
    <table class="table table-bordered">
        <tr>
            <th>Идентификатор заказа:</th>
            <td class="order-id"><?php echo $oid; ?></td>
        </tr>
        <?php 
        $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
        $num = mysqli_num_rows($ret);
        if ($num > 0) {
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
        <?php 
            }
        } else {
        ?>
        <tr>
            <td colspan="2">Заказ еще не обработан</td>
        </tr>
        <?php 
        }
        $st = 'Delivered';
        $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
        while ($num = mysqli_fetch_array($rt)) {
            $currentSt = $num['orderStatus'];
        }
        if ($st == $currentSt) { 
        ?>
        <tr>
            <td colspan="2" class="status-delivered">Продукт успешно доставлен</td>
        </tr>
        <?php 
        }
        ?>
    </table>
</div>

</body>
</html>

