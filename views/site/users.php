<users>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/create_user') ?>">Добавить системного администратора</a>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">ФИО</div>
            <div class="date-of-birth">Логин</div>
            <div class="phone-numbers">Роль</div>
        </div>
        <?php
        foreach ($users as $user) {
            echo '
            <div class="column">
                <div class="id">' . $user->id . '</div>
                <div class="fio">' . $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name . '</div>
                <div class="date-of-birth">' . $user->login . '</div>
                <div class="phone-numbers">' . $user->role_id . '</div>
            </div>';
        }
        ?>
    </div>
</users>