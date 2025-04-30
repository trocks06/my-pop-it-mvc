<departments>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/departments/create') ?>">Добавить подразделение</a>
            <a href="<?= app()->route->getUrl('/department_types/create') ?>">Добавить вид подразделения</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form>
                <label><input class="search-field" type="text"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">Название подразделения</div>
            <div class="date-of-birth">Вид подразделения</div>
        </div>
        <?php
        foreach ($departments as $department) {
            echo '
            <div class="column">
                <div class="id">' . $department->id . '</div>
                <div class="fio">' . $department->department_name . '</div>
                <div class="date-of-birth">' . $department->department_type_id . '</div>
            </div>';
        }
        ?>
    </div>
</departments>