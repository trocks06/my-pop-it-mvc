<h2>Абонент</h2>
<subscriber>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">ФИО</div>
            <div class="date-of-birth">Дата рождения</div>
            <div class="fio">Номера телефонов</div>
            <div class="department">Подразделение</div>
        </div>
        <div class="column">
            <div class="id"><?= $subscriber->id ?></div>
            <div class="fio"><?= $subscriber->last_name . ' ' . $subscriber->first_name . ' ' . $subscriber->middle_name ?></div>
            <div class="date-of-birth"><?= $subscriber->birth_date ?></div>
            <div class="fio">
                <?php
                if ($phones->count() > 0) {
                    foreach ($phones as $phone) {
                        echo $phone->phone_number . '<br>';
                    }
                } else {
                    echo 'Нет номеров';
                }
                ?>
            </div>
            <div class="department"><?= $departmentName ?></div>
        </div>;
    </div>
</subscriber>