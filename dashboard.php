
<!DOCTYPE html>
<html>
<head>
    <title>Панель управления читателя</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Панель управления читателя</h2>
    <?php
    $host = "tz1ak";
    $username = "root";
    $password = "";
    $dbname = "library1";


    $conn = new mysqli($host, $username, $password, $dbname);
    session_start();

    if (isset($_SESSION["readerID"])) {

        include_once 'includes/db_connection.php';

        $readerID = $_SESSION["readerID"];


        $sql = "SELECT * FROM Readers WHERE ID = $readerID";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $reader = $result->fetch_assoc();
            echo "<p>Добро пожаловать, " . $reader['FirstName'] . " " . $reader['LastName'] . "!</p>";

        } else {
            echo "Ошибка: Читатель не найден.";
        }

        $conn->close();
    } else {
        echo "Пожалуйста, войдите в систему.";
    }
    ?>
    <p><a href="index.php">Войти</a></p>
</body>
</html>
