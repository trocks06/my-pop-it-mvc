<h2>Подсчет абонентов</h2>
<form method="GET" action="<?= app()->route->getUrl('/subscribers/count') ?>">
    <fieldset style="width: fit-content; margin: 20px; padding: 20px; border-color: black">
        <legend>Фильтр</legend>

        <label>Подразделение
            <select name="department_id">
                <option value="">-- Все подразделения --</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department->id ?>"
                        <?= isset($_GET['department_id']) && $_GET['department_id'] == $department->id ? 'selected' : '' ?>>
                        <?= $department->department_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Помещение
            <select name="room_id">
                <option value="">-- Все помещения --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room->id ?>"
                        <?= isset($_GET['room_id']) && $_GET['room_id'] == $room->id ? 'selected' : '' ?>>
                        <?= $room->room_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <button type="submit" class="search-button">Подсчитать</button>
    </fieldset>
</form>

<?php if (isset($subscribersCount)): ?>
    <div style="width: 500px;margin: 0 auto; padding: 10px; background: #f0f0f0; border: black solid 2px">
        <h3 style="margin: 0">Количество абонентов: <?= $subscribersCount ?></h3>
    </div>
<?php endif; ?>