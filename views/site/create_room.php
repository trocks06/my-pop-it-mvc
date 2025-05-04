<h2>Создание помещения</h2>
<form method="post">
    <label>Название помещения <input type="text" name="room_name" value="<?= $old['room_name'] ?? '' ?>"></label>
    <label>Подразделение
        <select name="department_id">
            <?php
            foreach ($departments as $department) {
                echo '<option value="' . $department->id . '">' . $department->department_name . '</option>';
            }
            ?>
        </select>
    </label>
    <label>Вид помещения
        <select name="room_type_id">
            <?php
            foreach ($room_types as $room_type) {
                echo '<option value="' . $room_type->id . '">' . $room_type->type_name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Добавить помещение</button>
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