<!DOCTYPE html>
<html>
<head>
    <title>Сдать книгу</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>Сдать книгу:</h2>

<?php
// Подключение к базе данных
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

            $sqlCheckLoan = "SELECT ID FROM BookLoans WHERE BookID = ? AND ReaderID = ? AND ReturnDate IS NULL";
            if ($stmtCheckLoan = $conn->prepare($sqlCheckLoan)) {
                $readerID = $_SESSION["readerID"];
                $stmtCheckLoan->bind_param("ii", $bookCode, $readerID);
                $stmtCheckLoan->execute();
                $stmtCheckLoan->store_result();

                if ($stmtCheckLoan->num_rows == 1) {

                    $returnDate = date("Y-m-d"); // Текущая дата

                    $sqlUpdateLoan = "UPDATE BookLoans SET ReturnDate = ? WHERE BookID = ? AND ReaderID = ?";
                    if ($stmtUpdateLoan = $conn->prepare($sqlUpdateLoan)) {
                        $stmtUpdateLoan->bind_param("sii", $returnDate, $bookCode, $readerID);
                        if ($stmtUpdateLoan->execute()) {

                            $sqlUpdateBookStatus = "UPDATE Books SET Available = 1 WHERE ID = ?";
                            if ($stmtUpdateBookStatus = $conn->prepare($sqlUpdateBookStatus)) {
                                $stmtUpdateBookStatus->bind_param("i", $bookCode);
                                $stmtUpdateBookStatus->execute();
                                echo "Книга успешно возвращена!";
                            } else {
                                echo "Ошибка при обновлении статуса книги: " . $stmtUpdateBookStatus->error;
                            }
                            $stmtUpdateBookStatus->close();
                        } else {
                            echo "Ошибка при обновлении даты возврата: " . $stmtUpdateLoan->error;
                        }
                        $stmtUpdateLoan->close();
                    } else {
                        echo "Ошибка при подготовке запроса для обновления даты возврата.";
                    }
                } else {
                    echo "Запись о выдаче не найдена или книга уже возвращена.";
                }
                $stmtCheckLoan->close();
            } else {
                echo "Ошибка при подготовке запроса для проверки записи о выдаче.";
            }
        } else {
            echo "Пожалуйста, введите код книги.";
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="bookCode">Введите код книги:</label>
        <input type="text" id="bookCode" name="bookCode" required>
        <input type="submit" value="Вернуть книгу">
    </form>

    <?php
} else {
    echo "Пожалуйста, войдите в систему, чтобы вернуть книгу.";
}

$conn->close();
?>

<p><a href="index.php">Вернуться на главную</a></p>
</body>
</html>
