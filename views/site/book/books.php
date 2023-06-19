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

    <h1>Список книг</h1>

    <form method="post" class="search-from">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="search" placeholder="Поиск">
    </form>


    <a href="<?= app()->route->getUrl('/book-add') ?>">Добавить книгу</a>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Автор</th>
            <th scope="col">Год выпуска</th>
            <th scope="col">Издательство</th>
            <th scope="col">Isbn</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($book_list as $book) {
            ?>
            <tr>
                <td><a href="book/?id=<?= $book->book_id ?>"><?= $book->name ?></a></td>
                <td><?= $book->author ?></td>
                <td><?= $book->price ?></td>
                <td><?= $book->date_publish ?></td>
                <td><?= $book->isbn ?></td>
                <td><a href="book-delete?id=<?= $book->book_id ?>">Удалить</a></td>
            </tr>
            <?php
        }
        ?>
    </table>
</main>
