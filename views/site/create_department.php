<h2>Создание подразделения</h2>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Название подразделения <input type="text" name="department_name" value="<?= $old['department_name'] ?? '' ?>"></label>
    <label>Вид подразделения
        <select name="department_type_id">
            <?php
            foreach ($department_types as $department_type) {
                echo '<option value="' . $department_type->id . '">' . $department_type->type_name . '</option>';
            }
            ?>
        </select>
    </label>
    <button>Добавить подразделение</button>
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