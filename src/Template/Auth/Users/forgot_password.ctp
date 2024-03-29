<?php
$this->assign('title', __('Forgot Password'));
$this->assign('description', '');

?>


<?php
// echo $this->Flash->render('auth')
?>

<?php if (!isset($user->id)) { ?>

    <?= $this->Form->create($user); ?>

    <p><?= __('Enter your e-mail address below to reset your password.') ?></p>

    <?=
    $this->Form->input('email', [
        'label' => false,
        'placeholder' => __('Email'),
        'class' => 'form-control',
        'type' => 'email'
    ])

    ?>

    <?php if ((get_option('enable_captcha_forgot_password') == 'yes') && isset_captcha()) : ?>
        <div class="form-group captcha">
            <div id="captchaForgotpassword" style="display: inline-block;"></div>
        </div>
    <?php endif; ?>

    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>
    <?= $this->Form->end() ?>

<?php } else { ?>

    <?= $this->Form->create($user); ?>

    <?= $this->Form->hidden('id', ['value' => $user->id]); ?>

    <?=
    $this->Form->input('password', [
        'label' => false,
        'placeholder' => __('New Password'),
        'class' => 'form-control',
        'type' => 'password'
    ])

    ?>

    <?=
    $this->Form->input('confirm_password', [
        'label' => __('Re-enter New Password'),
        'label' => false,
        'placeholder' => __('Re-enter New Password'),
        'class' => 'form-control',
        'type' => 'password'
    ])

    ?>

    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-block btn-flat']); ?>

    <?= $this->Form->end() ?>
<?php } ?>

