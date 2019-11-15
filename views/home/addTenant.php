<style>
    /*    этот стиль есть в style.css */
    .error_input {
        border: 1px solid red;
    }

    .add__tenant_column {
        display: flex;
        flex-direction: column;
        margin: 0 auto;
        width: 500px;
    }

    .add__tenant_field {
        display: flex;
        flex-direction: column;
    }
</style>
<label class="page_title">Добавить арендатора</label>
<form action="?" id="addTenantForm" method="post">
    <div class="add__tenant_column">
        <?php foreach ($fields as $item): ?>
            <label for="#" class="add__tenant_field">
                <label class="tenant__form_title"><?=$item['caption']?></label>
                <input class="tenant__longform_input" type="text"
                       name="<?=$item['name']?>" placeholder="<?=$item['placeholder']?>">
            </label>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="mainTemplate" value="home">
    <input type="hidden" name="contentTemplate" value="listOfTenants">
    <input type="submit" class="btn_add" name="submit" value="Добавить" id="button_add_tenant">
</form>
