<?php
/**
 * @param $errorLogin
 */
?>
<form action="?" class="wrap_form" method="post" id="wrap_form__login">
    <div class="wrap_logo">L</div>
    <input type="hidden" name="action" value="login">
    <input type="text" class="wrap_input <?=$errorLogin!='login'?:'error_input'?>" name="login" placeholder="Email\Login">
    <input type="text" class="wrap_input <?=$errorLogin!='pass'?:'error_input'?>" name="pass" placeholder="Пароль">
    <input id="entrance_button" type="submit" class="wrap_button" value="Войти">
</form>