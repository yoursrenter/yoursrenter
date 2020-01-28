<div class="filter__menu">
    <div class="filter_link">
        <a href="#" class="filter__menu_arrow"><img src="/public/img/arrow-down-b_icon-icons_13.png" alt="arrow"></a>
        <a href="#" class="filter__menu_h">Фильтр
            <div class="filter">
                <div class="filter__header">
                    <h1 class="filter__header_h">Фильтр</h1>
                    <a class="close_x" href="#"><img src="/public/img/close_1.png" alt="X"></a>
                </div>
                <form action="#" method="post">
                    <ul class="filter__list">
                        <?php foreach ($filter_params as $item): ?>
                            <li class="filter__list_item"><?= $item['caption'] ?></li>
                            <input class="filter__list_checkbox" type="checkbox"
                                   name="<?= $item['name'] ?>" placeholder="<?= $item['placeholder'] ?>">
                        <?php endforeach; ?>
                    </ul>
                    <button class="filter__button">Выбрать</button>
                </form>

            </div>
        </a>

    </div>
    <div class="button_X">
        <button class="filter__menu_button"><a class="delete_x" href="#">X</a> Арендатор</button>
        <button class="filter__menu_button"><a class="delete_x" href="#">X</a> Объект</button>
    </div>
    <div class="wrap_for_search_1">
        <form class="search">
            <input class="search_area" type="text" placeholder="Поиск"><a href="#">
                <img class="search_loop" src="img/monotone_search_zoom_1.png" alt="loop"></a>
        </form>
    </div>
</div>