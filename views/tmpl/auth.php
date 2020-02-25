<div class="content algn-cnt" style="display: flex; justify-content: space-around;">
    <?php
        if ($id_current_user->getValue()) { ?>
        <a href="<?=BASE_URL?>exit">выход</a>
    <?php
        } else { ?>
            <span><a href="<?=BASE_URL?>registration">регистрация</a></span><span><a href="<?=BASE_URL?>login">вход</a></span>
    <?php
        } ?>
</div>
