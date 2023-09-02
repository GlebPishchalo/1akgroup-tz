<!DOCTYPE html>
<html>
<head>
    <title>Вход читателя</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>Вход читателя</h2>

<?php

include_once 'includes/db_connection.php';
$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";


$conn = new mysqli($host, $username, $password, $dbname);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $readerID = $_POST["readerID"];

    if (!empty($readerID)) {

        $sql = "SELECT * FROM Readers WHERE ID = $readerID";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION["readerID"] = $readerID;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Читатель не найден. Пожалуйста, проверьте введенные данные.";
        }
    } else {
        echo "Пожалуйста, выберите свою фамилию.";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <select name="readerID">
        <option value="">Выберите свою фамилию</option>
        <?php

           $sql = "SELECT * FROM Readers";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['LastName'] . "</option>";
            }
        }
        ?>
    </select>
    <input type="submit" value="Войти">
</form>

<p><a href="add_reader.php">Добавить свои данные</a></p>
<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>
