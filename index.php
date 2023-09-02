<!DOCTYPE html>
<html>
<head>
    <title>Сервис библиотеки</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>Добро пожаловать в сервис библиотеки!</h2>
<?php
session_start();

if (isset($_SESSION["readerID"])) {
    echo "<p>Вы вошли в систему. Выберите действие:</p>";
    echo "<ul>";
    echo "<li><a href='available_books.php'>Посмотреть список доступных книг</a></li>";
    echo "<li><a href='borrow_book.php'>Взять книгу</a></li>";
    echo "<li><a href='return_book.php'>Сдать книгу</a></li>";
    echo "<li><a href='logout.php'>Выйти из аккаунта</a></li>";
    echo "</ul>";
} else {
    echo "<p>Выберите действие:</p>";
    echo "<ul>";
    echo "<li><a href='login.php'>Вход читателя</a></li>";
    echo "<li><a href='add_reader.php'>Добавить свои данные</a></li>";
    echo "</ul>";
}
?>
</body>
</html>
<?php
