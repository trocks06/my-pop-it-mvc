<h2>Абонент</h2>
<subscriber>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">ФИО</div>
            <div class="date-of-birth">Дата рождения</div>
            <div class="fio" style="display: inline-flex; justify-content: space-evenly">Номера телефонов
            <form method="get" id="dep-filter" action="<?= app()->route->getUrl('/subscriber/' . $subscriber->id) ?>">
                <label for="dep" style="font-size: 24px">По подразделениям</label><br>
                    <select id="dep" name="department_id" onchange="document.getElementById('dep-filter').submit()">
                        <option value="">Все подразделения</option>
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department->id ?>" <?= $selectedDepartment == $department->id ? 'selected' : '' ?>>
                                <?= $department->department_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

            </form>
            </div>
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