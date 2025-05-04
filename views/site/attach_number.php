<form method="post">
    <label>Абонент
        <select name="subscriber_id">
            <?php
            foreach ($subscribers as $subscriber) {
                echo '<option value="' . $subscriber->id . '">' . $subscriber->last_name . ' ' . $subscriber->first_name . ' ' . $subscriber->middle_name . '</option>';
            }
            ?>
        </select>
    </label>
    <label>Телефон
        <select name="phone_id">
            <?php
            if (!empty($phones)) {
                foreach ($phones as $phone) {
                    echo '<option value="' . $phone->id . '">' . $phone->phone_number . '</option>';
                }
            } else {
                echo 'Нет доступных номеров';
            }
            ?>
        </select>
    </label>
    <button>Прикрепить номер к абоненту</button>
</form>
<?php if (!empty($error)): ?>
    <div style="color: red">
        <ul>
            <li><?=$error?></li>
        </ul>
    </div>
<?php endif; ?>