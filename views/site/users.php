<h2>Админы</h2>
<users>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/create_user') ?>">Добавить системного администратора</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form action="<?= app()->route->getUrl('/users') ?>">
                <label><input name="search_field" class="search-field" type="text" value="<?= $request->get('search_field') ?>"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="id">Аватар</div>
            <div class="fio">ФИО</div>
            <div class="date-of-birth">Логин</div>
            <div class="fio">Роль</div>
        </div>


        <?php foreach ($users as $user):
            $roleName = $user->role ? $user->role->role_name : 'Не указана';?>
            <div class="column">
                <div class="id"><?= $user->id ?></div>
                <div class="id">
                    <?php if ($user->avatar): ?>
                        <img alt="avatar" src="<?= "$user->avatar" ?>" width="100px" height="100px">
                    <?php else: ?>
                        <img alt="avatar" src="<?= "uploads/avatars/default_avatar.jpg" ?>" width="100px" height="100px">
                    <?php endif; ?>
                </div>
                <div class="fio"><?= $user->last_name . ' ' . $user->first_name . ' ' . ($user->middle_name ?? '') ?></div>
                <div class="date-of-birth"><?= $user->login ?></div>
                <div class="fio"><?= $roleName ?></div>
            </div>
        <?php endforeach; ?>
</users>