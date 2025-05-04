<h2>Создание телефона</h2>
<form method="post">
    <label>Номер телефона <input type="text" name="phone_number" value="<?= $old['phone_number'] ?? '' ?>"></label>
    <label>Абонент
        <select name="subscriber_id">
            <?php
            echo '<option value="">' . 'Не указывать' . '</option>';
            foreach ($subscribers as $subscriber) {
                echo '<option value="' . $subscriber->id . '">' . $subscriber->last_name . ' ' . $subscriber->first_name . ' ' . $subscriber->middle_name . '</option>';
            }
            ?>
        </select>
    </label>
    <label>Помещение
        <select name="room_id">
            <?php
            foreach ($rooms as $room) {
                echo '<option value="' . $room->id . '">' . $room->room_name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Добавить телефон</button>
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