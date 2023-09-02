
<!DOCTYPE html>
<html>
<head>
    <title>Список доступных книг</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Список доступных книг:</h2>

    <?php
    // Подключение к базе данных
    require_once 'includes/db_connection.php';
    $host = "tz1ak"; // Замените на хост базы данных
    $username = "root"; // Замените на имя пользователя базы данных
    $password = ""; // Замените на пароль пользователя базы данных
    $dbname = "library1"; // Замените на имя вашей базы данных

    // Устанавливаем соединение с базой данных
    $conn = new mysqli($host, $username, $password, $dbname);
    session_start();

    if (isset($_SESSION["readerID"])) {
        // SQL-запрос для получения списка доступных книг
        $sql = "SELECT * FROM Books WHERE Available = 1"; // Предполагаем, что у вас есть поле "Available" для обозначения доступных книг

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['Title'] . " (Код: " . $row['ID'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "Нет доступных книг.";
        }
    } else {
        echo "Пожалуйста, войдите в систему, чтобы просмотреть список доступных книг.";
    }

    $conn->close();
    ?>

    <p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>
