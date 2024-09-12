<?php

namespace k1app\controllers\auth;

use const k1app\K1APP_IMAGES_URL;
use function k1lib\common\set_magic_value;
use k1lib\html\div;

$alert_div = new div(null, 'login-alerts');
?><div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="/"><img src="<?php echo K1APP_IMAGES_URL . 'klan1.png' ?>" alt="Logo" style="height: 3rem"></a>
                </div>
                <h1 class="auth-title">Log in.</h1>
                <!--<p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>-->
                <?php echo $alert_div->__toString() ?>
                <form action="" method="post" data-parsley-validate>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            name="login"
                            type="text"
                            class="form-control form-control-xl"
                            placeholder="Username"
                            data-parsley-required="true"
                            >
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            name="pass"
                            type="password"
                            class="form-control form-control-xl"
                            placeholder="Password"
                            data-parsley-required="true"
                            >
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            Keep me logged in
                        </label>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    <input type="hidden" name="magic_value" value="<?php echo set_magic_value("login_form"); ?>">
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign
                            up</a>.</p>
                    <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
</div>