<!DOCTYPE html>
<html>
<head>
    <title>Добавить свои данные</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>Добавить свои данные:</h2>

<?php

include_once 'includes/db_connection.php';
$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";

// Устанавливаем соединение с базой данных
$conn = new mysqli($host, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $patronymic = $_POST["patronymic"];

    if (!empty($firstName) && !empty($lastName)) {
        // SQL-запрос для добавления читателя в базу данных
        $sql = "INSERT INTO Readers (FirstName, LastName, Patronymic) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Привязываем параметры
            $stmt->bind_param("sss", $firstName, $lastName, $patronymic);

            // Выполняем запрос
            if ($stmt->execute()) {
                echo "Данные успешно добавлены. Теперь вы можете войти в систему.";
            } else {
                echo "Ошибка при добавлении данных: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Ошибка при выполнении запроса.";
        }

        $conn->close();
    } else {
        echo "Пожалуйста, заполните обязательные поля: Имя и Фамилия.";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="firstName">Имя:</label>
    <input type="text" id="firstName" name="firstName" required><br>

    <label for="lastName">Фамилия:</label>
    <input type="text" id="lastName" name="lastName" required><br>

    <label for="patronymic">Отчество:</label>
    <input type="text" id="patronymic" name="patronymic"><br>

    <input type="submit" value="Добавить">
</form>

<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>
