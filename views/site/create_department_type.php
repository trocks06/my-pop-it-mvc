<h2>Создание типа подразделения</h2>
<form method="post">
    <label>Название вида подразделения <input type="text" name="type_name" value="<?= $old['type_name'] ?? '' ?>"></label>
    <button>Добавить вид подразделения</button>
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