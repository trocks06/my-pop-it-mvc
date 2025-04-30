<rooms>
    <div class="buttons">
        <div class="buttons-left">
            <a href="">Добавить помещение</a>
            <a href="<?= app()->route->getUrl('/room_types/create') ?>">Добавить вид помещения</a>
        </div>
        <div class="search">
            <h4>Поиск</h4>
            <form>
                <label><input class="search-field" type="text"></label>
                <button class="search-button">Найти</button>
            </form>
        </div>
    </div>
    <div class="data">
        <div class="column column-header">
            <div class="id">ID</div>
            <div class="fio">Название/номер помещения</div>
            <div class="date-of-birth">Подразделение</div>
            <div class="phone-numbers">Вид помещения</div>
        </div>
        <div class="column">
            <div class="id">ID</div>
            <div class="fio">Название/номер помещения</div>
            <div class="date-of-birth">Подразделение</div>
            <div class="phone-numbers">Вид помещения</div>
        </div>
    </div>
</rooms>