<?php
session_start(); // Начинаем сессию здесь

// Если сессия еще не инициализирована, создаем пустой массив контактов
if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список контактов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Список контактов</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Форма для добавления контакта -->
    <form id="contact-form" method="POST" action="contact.php">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="phone">Номер телефона:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Добавить контакт</button>
    </form>

    <h2 class="my-4">Ваши контакты</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Номер телефона</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['contacts']) && count($_SESSION['contacts']) > 0):
                foreach ($_SESSION['contacts'] as $index => $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['name']) ?></td>
                        <td><?= htmlspecialchars($contact['phone']) ?></td>
                        <td>
                            <a href="contact.php?delete=<?= $index ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; 
            else: ?>
                <tr>
                    <td colspan="3">Контакты отсутствуют</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Подключаем jQuery и плагины для работы с масками и формами -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        // Применение маски для ввода телефона
        $('#phone').mask('+7 (000) 000-00-00');

        // Обработка отправки формы
        $('#contact-form').on('submit', function(e) {
            let name = $('#name').val();
            let phone = $('#phone').val();

            // Проверка длины имени
            if (name.length < 3) {
                alert('Имя должно быть не менее 3 символов.');
                e.preventDefault(); // Останавливаем отправку формы
                return false;
            }

            // Преобразуем номер телефона в формат +79012345678
            phone = phone.replace(/\D/g, ''); // Убираем все нецифровые символы
            phone = '+7' + phone.substr(1); // Добавляем префикс +7
            $('#phone').val(phone); // Устанавливаем преобразованное значение

            return true; // Отправляем форму
        });
    });
</script>
</body>
</html>