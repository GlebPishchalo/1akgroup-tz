<?php
$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";


$conn = new mysqli($host, $username, $password, $dbname);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $readerID = $_POST["readerID"];

    if (!empty($readerID)) {

        include_once 'includes/db_connection.php';


        $sql = "SELECT * FROM Readers WHERE ID = ?";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("i", $readerID);


            $stmt->execute();


            $result = $stmt->get_result();

            if ($result->num_rows == 1) {

                $row = $result->fetch_assoc();
                $_SESSION["readerID"] = $readerID;
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Читатель не найден. Пожалуйста, проверьте введенные данные.";
            }

            $stmt->close();
        } else {
            echo "Ошибка при выполнении запроса.";
        }

        $conn->close();
    } else {
        echo "Пожалуйста, выберите свою фамилию.";
    }
} else {

    header("Location: login.php");
    exit();
}
?>
