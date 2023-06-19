<?php

use Src\Auth\Auth;

?>
<div class="sidebar">
    <div class="sidebar-top">
        <p class="logo"><img class="logo-img" src="/mvc/public/static/media/lib_logo.png" alt="logo-ico">Библиотека
        </p>
        <nav>
            <a href="<?= app()->route->getUrl('/books') ?>">Книги</a>
            <a href="<?= app()->route->getUrl('/readers') ?>">Читатели</a>

            <?php if (Auth::user()->role->role === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/genre') ?>">Жанры</a>
                <a href="<?= app()->route->getUrl('/publishers') ?>">Издательства</a>
                <a href="<?= app()->route->getUrl('/halls') ?>">Залы</a>
                <a href="<?= app()->route->getUrl('/librarians') ?>">Сотрудники</a>
            <?php endif; ?>
        </nav>
    </div>
    <div class="sidebar-bottom">
        <a href="<?= app()->route->getUrl('/profile') ?>" class="sidebar-link sidebar-img-link"><img
                    src="/mvc/public/static/media/profile_icon.svg"
                    alt="profile-icon"><?= app()->auth::user()->name ?>
        </a>
        <a href="<?= app()->route->getUrl('/logout') ?>" class="sidebar-link sidebar-img-link"><img
                    src="/mvc/public/static/media/logout_icon.svg" alt="logout-icon">Выход</a>
    </div>
</div>
<main>
    <h1>Добавление библиотекаря</h1>
    <?php if ($errors) {
        echo $errors;
    } ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label for="name">ФИО</label>
        <input type="text" name="name">

        <label for="name">Логин</label>
        <input type="text" name="login">

        <label for="password">Пароль</label>
        <input type="password" name="password">

        <button class="submit-btn">Добавить</button>
    </form>
</main>