<h2>Создание типа помещения</h2>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Название вида помещения <input type="text" name="type_name" value="<?= $old['type_name'] ?? '' ?>"></label>
    <button>Добавить вид помещения</button>
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