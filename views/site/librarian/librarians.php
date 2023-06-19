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

<div class="main">

    <h1>Список сотрудников</h1>
    <a href="<?= app()->route->getUrl('/librarian-add') ?>">
        Добавить библиотекаря
    </a>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">ФИО</th>
            <th scope="col">Логин</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($lib_list as $lib) {
            ?>
            <tr>
                <th scope="row"><?= $lib->name ?></th>
                <th scope="row"><?= $lib->login ?></th>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
