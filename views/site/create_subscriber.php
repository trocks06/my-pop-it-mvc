<h2>Создание абонента</h2>
<form method="post">
    <label>Фамилия <input type="text" name="last_name" value="<?= $old['last_name'] ?? '' ?>"></label>
    <label>Имя <input type="text" name="first_name" value="<?= $old['first_name'] ?? '' ?>"></label>
    <label>Отчество <input type="text" name="middle_name" value="<?= $old['middle_name'] ?? '' ?>"></label>
    <label>Дата рождения <input type="date" name="birth_date" value="<?= $old['birth_date'] ?? '' ?>"></label>
    <label>Подразделение
        <select name="department_id">
            <?php
            foreach ($departments as $department) {
                echo '<option value="' . $department->id . '">' . $department->department_name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Добавить абонента</button>
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