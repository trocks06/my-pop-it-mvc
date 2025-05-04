<h2>Телефоны</h2>
<phones>
    <div class="buttons">
        <div class="buttons-left">
            <a href="<?= app()->route->getUrl('/phones/create') ?>">Добавить телефон</a>
            <a href="<?= app()->route->getUrl('/attach_phone') ?>">Прикрепить номер абоненту</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form action="<?= app()->route->getUrl('/phones') ?>">
                <label><input name="search_field" class="search-field" type="text" value="<?= $request->get('search_field') ?>"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">Номер телефона</div>
            <div class="fio">Абонент</div>
            <div class="phone-numbers">Помещение</div>
            <div class="phone-numbers">Отвязка</div>
        </div>
        <?php foreach ($phones as $phone):
            $subscriberName = 'Отсутствует';
            if ($phone->subscriber) {
                $subscriberName = $phone->subscriber->last_name . ' ' .
                    $phone->subscriber->first_name . ' ' .
                    ($phone->subscriber->middle_name ?? '');
            }
            $roomName = 'Не указано';
            if ($phone->room) {
                $roomName = $phone->room->room_name;
            }
            ?>
            <div class="column">
                <div class="id"><?= $phone->id ?></div>
                <div class="fio"><?= $phone->phone_number ?></div>
                <div class="fio"><?= trim($subscriberName) ?></div>
                <div class="phone-numbers"><?= $roomName ?></div>
                <div class="phone-numbers"><a style="width: 100%; height: 100%; display: inline-flex; align-items: center; justify-content: center" href="<?= app()->route->getUrl('/detach_phone/' . $phone->id) ?>" class="detach-link">Отвязать</a></div>

            </div>
        <?php endforeach; ?>
    </div>
</phones>