<header class="bd-header bg-dark py-3 d-flex align-items-stretch border-bottom border-dark"
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="container-fluid d-flex align-items-center">
        <h1 class="d-flex align-items-center fs-4 text-white mb-0">
            Библиотека
        </h1>
    </div>
</header>
<div class="form-container">
    <h2>Авторизация</h2>
    <h3><?= $message ?? ''; ?></h3>
    <h3><?= app()->auth->user()->name ?? ''; ?></h3>
    <?php
    if (!app()->auth::check()):
    ?>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Логин<input type="text" name="login"></label>
        <label>Пароль<input type="password" name="password"></label>
        <button class="submit-btn">Войти</button>
    </form>
</div>
<?php endif;