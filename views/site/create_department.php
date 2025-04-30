<form method="post">
    <label>Название подразделения <input type="text" name="department_name"></label>
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