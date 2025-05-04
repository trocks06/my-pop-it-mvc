<h2>Помещения</h2>
<rooms>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/rooms/create') ?>">Добавить помещение</a>
            <a href="<?= app()->route->getUrl('/room_types/create') ?>">Добавить вид помещения</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form action="<?= app()->route->getUrl('/rooms') ?>">
                <label><input name="search_field" class="search-field" type="text" value="<?= $request->get('search_field') ?>"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">Название/номер помещения</div>
            <div class="date-of-birth">Подразделение</div>
            <div class="phone-numbers">Вид помещения</div>
        </div>
        <?php
        foreach ($rooms as $room) {
            $departmentName = $room->department ? $room->department->department_name : 'Не указано';
            $roomTypeName = $room->roomType ? $room->roomType->type_name : 'Не указано';

            echo '
            <div class="column">
                <div class="id">' . $room->id . '</div>
                <div class="fio">' . $room->room_name . '</div>
                <div class="date-of-birth">' . $departmentName . '</div>
                <div class="phone-numbers">' . $roomTypeName . '</div>
            </div>';
        }
        ?>
    </div>
</rooms>