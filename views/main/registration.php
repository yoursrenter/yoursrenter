<h3 class="wrap_h3">Регистрация</h3>
<div class="wrap_form wrap_form__reg">
    <div class="wrap_logo wrap_logo__reg">L</div>
    <form action="?" id="wrap_form__reg" method="post">
        <input type="hidden" name="action" value="registration">
        <input type="text" class="wrap_input" name="organizationName" placeholder="Наименование организации" title="123">
        <input type="text" class="wrap_input" name="organizationAddress" placeholder="Адрес организации">
        <div id="wrap_input__numbers">
            <label for="inn" class="wrap_input__line"><p>ИНН</p>
                <input id="inn" type="text" class="wrap_input" name="inn" placeholder="1111111111111">
            </label>
            <label for="kpp" class="wrap_input__line"><p>КПП</p>
                <input id="kpp" type="text" class="wrap_input" name="kpp" placeholder="1111111111">
            </label>
            <label for="ogrn" class="wrap_input__line"><p>ОГРН</p>
                <input id="ogrn" type="text" class="wrap_input" name="ogrn" placeholder="1111111111111">
            </label>
            <label for="kor_schet" class="wrap_input__line"><p>Кор/счёт</p>
                <input id="kor_schet" type="text" class="wrap_input" name="korSchet" placeholder="11111111111111111111">
            </label>
            <label for="schet" class="wrap_input__line"><p>Счёт</p>
                <input id="schet" type="text" class="wrap_input" name="schet" placeholder="11111111111111111111">
            </label>
        </div>
        <input type="text" class="wrap_input" name="bank" placeholder="Банк">
        <div class="wrap_input__line wrap_input__bottom">
            <input type="text" class="wrap_input" name="login" placeholder="Почта">
            <input type="text" class="wrap_input" name="pass" placeholder="Пароль">
        </div>
        <input id="registration_button" type="submit" class="wrap_button" name="button" value="Зарегистрироваться">
    </form>
</div>