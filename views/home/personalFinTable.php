<div class="finTable__menu">
    <a href="#" class="finTable__menu_link" id="tenants_link">Арендаторы</a>
    <a href="#" class="finTable__menu_arrow"> -> </a>
    <h2 class="finTable__menu_company"><?= $tenant['tenant_name'] ?></h2>
</div>
<form action="?" class="finData" id="tenant_info" method="post">
    <?php foreach ($column_names as $key => $value): ?>
        <h2 class="finData__title"><?= $value ?></h2>
        <input type="text" class="finData__form" id="<?= $key ?>" value="<?= $tenant[$key] ?>">
    <?php endforeach; ?>
    <input type="hidden" name="mainTemplate" value="home">
    <input type="hidden" name="contentTemplate" value="listOfTenants">
</form>
<ul class="paymentMenu">
    <li class="paymentMenu__title">Постоянная</li>
    <li class="paymentMenu__title">Переменная</li>
    <li class="paymentMenu__title">Оплата</li>
</ul>
<ul class="paymentMenu__arrows">
    <li><img class="paymentMenu__arrows_arrow" src="img/arrow-down-b_icon-icons_13.png" alt="arrrow"></li>
    <li><img class="paymentMenu__arrows_arrow" src="img/arrow-down-b_icon-icons_13.png" alt="arrrow"></li>
    <li><img class="paymentMenu__arrows_arrow" src="img/arrow-down-b_icon-icons_13.png" alt="arrrow"></li>
</ul>
<form action="#" class="personal__form">
    <?php foreach ($fin_info as $key => $item): ?>
        <input type="text" class="personal__form_data" id="id_<?= $key ?>" value="<?= $item['month'] ?>">
        <?php foreach ($item['content'] as $prop => $value): ?>
            <input type="text" class="personal__form_data" id="id_<?= $key ?>_<?= $prop ?>" value="<?= $value ?>">
        <?php endforeach; ?>
    <?php endforeach; ?>
</form>
<div class="financial__result">
    <input type="text" class="financial__result_data" id="id_sum_name" value="Итого">
    <?php foreach ($fin_info_sum as $prop => $value): ?>
        <input type="text" class="financial__result_data" id="id_sum_<?= $prop ?>" value="<?= $value ?>">
    <?php endforeach; ?>
</div>
<div class="wrap_for_field">
    <p class="new__field_title">Добавить поле</p>
    <div class="new__field">
        <a href="../modal.html"><img src="img/add_(1)_4.png" alt="add"></a>
    </div>
</div>