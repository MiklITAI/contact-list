<?php
session_start(); // Начинаем сессию

// Инициализация списка контактов, если он не был создан ранее
if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}

// Проверка на удаление контакта
if (isset($_GET['delete'])) {
    $index = (int)$_GET['delete'];
    if (isset($_SESSION['contacts'][$index])) {
        unset($_SESSION['contacts'][$index]);
        $_SESSION['contacts'] = array_values($_SESSION['contacts']); // Пересобираем массив, чтобы убрать пробелы в индексах
    }
}

// Проверка, была ли отправлена форма добавления контакта
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Валидация данных
    if (strlen($name) >= 3 && preg_match('/^\+7\d{10}$/', $phone)) {
        // Добавляем контакт в сессию
        $_SESSION['contacts'][] = ['name' => $name, 'phone' => $phone];
    } else {
        // Обработка ошибки, если имя слишком короткое или номер некорректен
        $_SESSION['error'] = "Имя должно быть не менее 3 символов и номер телефона должен быть в формате +79012345678";
    }
}

// Перенаправление обратно на главную страницу
header('Location: index.php');
exit;