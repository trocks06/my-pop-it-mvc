<h2>Абоненты</h2>
<subscribers>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/subscribers/create') ?>">Добавить абонента</a>
            <a href="<?= app()->route->getUrl('/attach_phone') ?>">Прикрепить номер абоненту</a>
            <a href="<?= app()->route->getUrl('/subscribers/count') ?>">Подсчитать абонентов</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form action="<?= app()->route->getUrl('/subscribers') ?>">
                <label><input name="search_field" class="search-field" type="text" value="<?= $request->get('search_field') ?>"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">ФИО</div>
            <div class="date-of-birth">Дата рождения</div>
            <div class="department">Подразделение</div>
        </div>
        <?php
        foreach ($subscribers as $subscriber) {
            $departmentName = $subscriber->department->department_name;
            echo '
            <a href="' . app()->route->getUrl('/subscriber/' . $subscriber->id) . '">
            <div class="column">
                <div class="id">' . $subscriber->id . '</div>
                <div class="fio">' . $subscriber->last_name . ' ' . $subscriber->first_name . ' ' . $subscriber->middle_name . '</div>
                <div class="date-of-birth">' . $subscriber->birth_date . '</div>
                <div class="department">' . $departmentName . '</div>
            </div></a>';
        } ?>
    </div>
</subscribers>