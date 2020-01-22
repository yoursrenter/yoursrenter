<style>
    .debtor {
        background: #FFD1D1;
    }

    .financial__line {
        cursor: pointer;
    }

    .financial__line:hover {
        outline: 1px solid #45bcdb;
    }

    .financial__form {
        display: block;
    }
</style>
<p class="page_title">Финансовая таблица</p>
<div class="wrap_for_search">
    <form class="search">
        <input class="search_area" type="text" placeholder="Поиск">
        <a href="#"><img class="search_loop" src="img/monotone_search_zoom_1.png" alt="loop"></a>
    </form>
</div>

<div class="financial__table">
    <ul class="financial__table_title">
        <?php foreach ($column_names as $item): ?>
            <li class="name_li"><?= $item['name'] ?>
                <?php if ($item['content']): ?>
                    <ul class="subname">
                        <?php foreach ($item['content'] as $subitem): ?>
                            <li class="subname_li"><?= $subitem ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

    </ul>
    <ul class="financial__table_arrow">
        <?php foreach ($column_names as $item): ?>
            <li class="finTable_arrow"><img src="/public/img/arrow-down-b_icon-icons_13.png" alt="arrrow"></li>
        <?php endforeach; ?>
    </ul>

</div>
<form action="?" class="financial__form" id="financial_form" method="post">
    <?php foreach ($data as $key => $item): ?>
        <div class="financial__line" id="financial_line_<?= $key ?>">
            <?php $isDebtor = $item['isDebtor'] ?>
            <input type="text" class="financial__form_data" name="tenant_name"
                   value="<?= $item['tenant_name'] ?>" readonly>
            <input type="text" class="financial__form_data" name="contract_name"
                   value="<?= $item['contract_name'] ?>" readonly>
            <input type="text" class="financial__form_data" name="rent"
                   value="<?= $item['rent'] ?>" readonly>
            <input type="text" class="financial__form_data <?= !$isDebtor ? '' : 'debtor' ?>" name="diff_sum"
                   value="<?= $item['diff_sum'] ?>" readonly>
        </div>
    <?php endforeach; ?>
    <input type="hidden" name="mainTemplate" value="home">
    <input type="hidden" name="contentTemplate" value="personalFinTable">
</form>
<div class="financial__result">
    <input type="text" class="financial__result_data" id="finResult1" value="Итого">
    <input type="text" class="financial__result_data" id="finResult2" value="">
    <input type="text" class="financial__result_data" id="finResult3" value="19 200 000">
    <input type="text" class="financial__result_data" id="finResult4" value="19 000 000">
</div>
<form action="#" method="post" id="addFinanceForm">
    <input type="hidden" name="mainTemplate" value="home">
    <input type="hidden" name="contentTemplate" value="addTenant">
    <input type="submit" class="btn_add" value="Добавить">
</form>
