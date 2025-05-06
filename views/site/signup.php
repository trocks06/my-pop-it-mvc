<h2>Регистрация нового пользователя</h2>
<form method="post" enctype="multipart/form-data">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Фамилия <input type="text" name="last_name" value="<?= $old['last_name'] ?? '' ?>"></label>
    <label>Имя <input type="text" name="first_name" value="<?= $old['first_name'] ?? '' ?>"></label>
    <label>Отчество <input type="text" name="middle_name" value="<?= $old['middle_name'] ?? '' ?>"></label>
    <label>Логин <input type="text" name="login" value="<?= $old['login'] ?? '' ?>"></label>
    <label>Пароль <input type="password" name="password"></label>
    <label>Аватар<input type="file" name="avatar" accept="image/*"></label>
    <label>Роль
        <select name="role_id">
            <?php
            foreach ($roles as $role) {
                echo '<option value="' . $role->id . '">' . $role->role_name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Зарегистрироваться</button>
</form>
<?php if (!empty($errors)): ?>
    <div style="color: red">
        <ul>
            <?php foreach ($errors as $field => $fieldErrors): ?>
                <?php foreach ($fieldErrors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>