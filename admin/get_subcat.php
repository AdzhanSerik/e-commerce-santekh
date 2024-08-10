<?php
include('include/config.php');

// Проверяем, что параметр "cat_id" не пустой
if(!empty($_POST["cat_id"])) 
{
    // Получаем значение "cat_id" из POST-запроса
    $id = intval($_POST['cat_id']);
    
    // Выполняем запрос к базе данных для получения подкатегорий по ID категории
    $query = mysqli_query($con, "SELECT * FROM subcategory WHERE categoryid=$id");
    ?>
    <!-- Начало списка подкатегорий -->
    <option value="">Выберите подкатегорию</option>
    <?php
    // Проходим по результатам запроса и выводим каждую подкатегорию в виде опции
    while($row = mysqli_fetch_array($query))
    {
        ?>
        <option value="<?php echo htmlentities($row['id']); ?>">
            <?php echo htmlentities($row['subcategory']); ?>
        </option>
        <?php
    }
}
?>
