<p class="page_title">Список арендаторов</p>
<?=$filter_content?>
<table class="table-sort">
    <thead class="table_header">
    <tr>
        <th class="table_header"><input class="table__checkbox" type="checkbox"></th>
        <?php foreach ($column_names as $column_name): ?>
            <th class="table_header"><?= $column_name ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>&nbsp;</td>
        <?php for ($i = 0; $i < count($column_names); $i++): ?>
            <td><img class="table_arrow" src="/public/img/arrow-down-b_icon-icons_13.png" alt="arrow"></td>
        <?php endfor; ?>
    </tr>
    <?php foreach ($data as $item): ?>
        <tr id="tenant_1" class="table__content">
            <td class="table__content_info"><input class="table__checkbox" type="checkbox"></td>
            <td class="table__content_info"><?= $item['tenant_name'] ?></td>
            <td class="table__content_info"><?= $item['contract_name'] ?></td>
            <td class="table__content_info"><?= $item['created_at'] ?></td>
            <td class="table__content_info"><?= $item['gettingcontract_at'] ?></td>
            <td class="table__content_info"><?= $item['expiration_at'] ?></td>
            <td class="table__content_info"><?= $item['area'] ?></td>
            <td class="table__content_info"><?= $item['rent_object'] ?></td>
            <td class="table__content_info"><?= $item['payment_at'] ?></td>
            <td class="table__content_info"><?= $item['rent'] ?></td>
            <td class="table__content_info"><?= $item['deposit'] ?></td>
        </tr>
        <tr id="tenant_1_info_caption" class="add__info table__content_hide">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="add__info_1">Телефон</td>
            <td class="add__info_1">Эл.почта</td>
            <td class="add__info_1">Дата платежа</td>
            <td class="add__info_1">Дата акта доступа</td>
        </tr>
        <tr id="tenant_1_info_text" class="add__info table__content_hide">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="add__info_2"><?= $item['tenant_phone'] ?></td>
            <td class="add__info_2"><?= $item['tenant_email'] ?></td>
            <td class="add__info_2"><?= $item['payment_at'] ?></td>
            <td class="add__info_2"><?= $item['available_act_at'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="scroll_area">
    <div class="scrollbar_track"></div>
</div>
<form action="?" method="post">
    <input type="submit" class="btn_add" value="Добавить">
    <input type="hidden" name="mainTemplate" value="home">
    <input type="hidden" name="contentTemplate" value="addTenant">
</form>