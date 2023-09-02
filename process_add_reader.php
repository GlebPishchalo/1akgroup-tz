<?php

include_once 'includes/db_connection.php';
$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";


$conn = new mysqli($host, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $patronymic = $_POST["patronymic"];

    if (!empty($firstName) && !empty($lastName)) {

        $sql = "INSERT INTO Readers (FirstName, LastName, Patronymic) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("sss", $firstName, $lastName, $patronymic);


            if ($stmt->execute()) {
                echo "Данные успешно добавлены. Теперь читатель может войти в систему.";
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
} else {

    header("Location: add_reader.php");
    exit();
}
?>
