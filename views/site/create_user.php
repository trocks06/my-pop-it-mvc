<h2>Создание пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
    <label>Фамилия <input type="text" name="last_name"></label>
    <label>Имя <input type="text" name="first_name"></label>
    <label>Отчество <input type="text" name="middle_name"></label>
    <label>Логин <input type="text" name="login"></label>
    <label>Пароль <input type="password" name="password"></label>
    <label>Роль
        <select name="role_id">
            <?php
            foreach ($roles as $role) {
                echo '<option value="' . $role->id . '">' . $role->name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Зарегистрироваться</button>
</form>