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
    <h1>Главная</h1>
    <p class="txt">На главной странице представлены наиболее популярные книги</p>
    <div class="popular-book-list">
        <?php
        foreach ($book_list as $book) {
            ?>
            <div class="popular-book-list-itm">
                <p class="title"><?= $book->name ?></p>
                <div class="half-block">
                    <div>
                        <p class="subtitle"><?= $book->author ?></p>
                        <p class="subtitle"><?= $book->date_publish ?></p>
                    </div>
                    <p class="price"><?= $book->price ?></p>
                </div>
                <div class="bottom-block">
                    <a class="annotation-btn" href="book/?id=<?= $book->book_id ?>">Перейти к аннотации -></a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</main>
