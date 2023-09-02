<!DOCTYPE html>
<html>
<head>
    <title>Взять книгу</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>Взять книгу:</h2>

<?php

include_once 'includes/db_connection.php';
$host = "tz1ak";
$username = "root";
$password = "";
$dbname = "library1";


$conn = new mysqli($host, $username, $password, $dbname);
session_start();

if (isset($_SESSION["readerID"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookCode = $_POST["bookCode"];

        if (!empty($bookCode)) {

            $sqlCheckAvailability = "SELECT Available FROM Books WHERE ID = ?";
            if ($stmtCheckAvailability = $conn->prepare($sqlCheckAvailability)) {
                $stmtCheckAvailability->bind_param("i", $bookCode);
                $stmtCheckAvailability->execute();
                $stmtCheckAvailability->store_result();

                if ($stmtCheckAvailability->num_rows == 1) {
                    $stmtCheckAvailability->bind_result($available);
                    $stmtCheckAvailability->fetch();

                    if ($available == 1) {

                        $sqlUpdateBookStatus = "UPDATE Books SET Available = 0 WHERE ID = ?";
                        if ($stmtUpdateBookStatus = $conn->prepare($sqlUpdateBookStatus)) {
                            $stmtUpdateBookStatus->bind_param("i", $bookCode);
                            if ($stmtUpdateBookStatus->execute()) {

                                $readerID = $_SESSION["readerID"];
                                $borrowDate = date("Y-m-d");


                                $sqlInsertLoan = "INSERT INTO BookLoans (ReaderID,BookID, LoanDate, ReturnDate) VALUES (?, ?, ?, ?)";
                                if ($stmtInsertLoan = $conn->prepare($sqlInsertLoan)) {
                                    $stmtInsertLoan->bind_param("iiss",$readerID, $bookCode,  $borrowDate, $dueDate);
                                    if ($stmtInsertLoan->execute()) {
                                        echo "Книга успешно взята!";
                                    } else {
                                        echo "Ошибка при записи о выдаче: " . $stmtInsertLoan->error;
                                    }
                                    $stmtInsertLoan->close();
                                } else {
                                    echo "Ошибка при подготовке запроса.";
                                }
                            } else {
                                echo "Ошибка при взятии книги: " . $stmtUpdateBookStatus->error;
                            }
                            $stmtUpdateBookStatus->close();
                        } else {
                            echo "Ошибка при подготовке запроса.";
                        }
                    } else {
                        echo "Извините, эта книга уже взята.";
                    }
                } else {
                    echo "Книга не найдена.";
                }
                $stmtCheckAvailability->close();
            } else {
                echo "Ошибка при подготовке запроса.";
            }
        } else {
            echo "Пожалуйста, введите код книги.";
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="bookCode">Введите код книги:</label>
        <input type="text" id="bookCode" name="bookCode" required>
        <input type="submit" value="Взять книгу">
    </form>

    <?php
} else {
    echo "Пожалуйста, войдите в систему, чтобы взять книгу.";
}

$conn->close();
?>

<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>