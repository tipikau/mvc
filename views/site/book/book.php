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
<?php
foreach ($book as $b) {
    ?>

    <main>
    <h1><?= $b->name ?></h1>

    <a href="/book-update?id=<?= $b->book_id ?>">Обновить данные о книге</a>

    <div>
        <div class="half-block">
            <div>
                <p><?= $b->author ?></p>
                <p><?= $b->date_publish ?></p>
            </div>

            <div class="price">
                <p><?= $b->price ?></p>
            </div>
        </div>

        <p><?= $b->annotation ?></p>
    </div>

    <?php
}
if ($cover) {
    foreach ($cover as $c) {
        ?>
        <img class="cover" src="../../<?= $c->cover ?>">
        <?php
    }
}

if ($reader_list) {
    ?>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Номер читательского билета</th>
            <th scope="col">ФИО</th>
            <th scope="col">Дата выдачи</th>
            <th scope="col">Дата возврата</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($reader_list as $reader) {
            ?>
            <tr>
            <td><?= $reader->id ?></td>
            <td><?= $reader->fio ?></td>
            <td><?= $reader->date_issue ?></td>
            <?php
            if ($reader->date_back === null) {
                ?>
                <td><a href="/date_back_add?id=<?= $book_id ?>"</td>
                <?php
            } else {
                ?>
                <td><?= $reader->date_back ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php
}
?>
    </main>
<?php

