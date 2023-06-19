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
    <h1>Список читателей</h1>
    <a href="<?= app()->route->getUrl('/reader-add') ?>">
        Добавить читателя
    </a>
    <form method="post" class="search-from">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="search" placeholder="Поиск">
    </form>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Имя</th>
            <th scope="col">Номер билета</th>
            <th scope="col">Адрес</th>
            <th scope="col">Номер телефона</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($reader_list as $reader) {
            ?>
            <tr>
                <td><a href="reader?id=<?= $reader->reader_id ?>"> <?= $reader->fio ?></a></td>
                <td><?= $reader->reader_id ?></td>
                <td><?= $reader->adress ?></td>
                <td><?= $reader->phone_number ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
