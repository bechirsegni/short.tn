<?php
$this->assign('title', __('Edit Plan'));
$this->assign('description', '');
$this->assign('content_title', __('Edit Plan'));
?>

<link rel="stylesheet"
      href="//cdn.rawgit.com/olance/jQuery-switchButton/e8a0e7ce8d735bcf9d417a6d8922790eeefee35c/jquery.switchButton.css">
<style>
    .switch-button-label {
        font-size: 25px;
        line-height: 25px;
    }
</style>

<div class="box box-primary">
    <div class="box-body">

        <?= $this->Form->create($plan); ?>

        <?= $this->Form->hidden('id'); ?>

        <?=
        $this->Form->input('enable', [
            'label' => __('Enable')
        ]);

        ?>

        <?=
        $this->Form->input('title', [
            'label' => __('Title'),
            'class' => 'form-control',
            'type' => 'text'
        ]);

        ?>

        <div class="row">
            <div class="col-sm-6">
                <?=
                $this->Form->input('monthly_price', [
                    'label' => __('Monthly Price'),
                    'class' => 'form-control',
                    'type' => 'text'
                ]);

                ?>
            </div>
            <div class="col-sm-6">
                <?=
                $this->Form->input('yearly_price', [
                    'label' => __('Yearly Price'),
                    'class' => 'form-control',
                    'type' => 'text'
                ]);

                ?>
            </div>
        </div>

        <?=
        $this->Form->input('description', [
            'label' => __('Description'),
            'class' => 'form-control text-editor',
            'type' => 'textarea'
        ]);

        ?>

        <table class="table table-hover table-striped">
            <tr>
                <td style="font-weight: bold;"><?= __('Edit Link') ?></td>
                <td><?= $this->Form->checkbox('edit_link', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Edit Long URL') ?></td>
                <td><?= $this->Form->checkbox('edit_long_url', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Remove Ads') ?></td>
                <td><?= $this->Form->checkbox('disable_ads', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Remove Captcha') ?></td>
                <td><?= $this->Form->checkbox('disable_captcha', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Direct') ?></td>
                <td><?= $this->Form->checkbox('direct', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Custom Alias') ?></td>
                <td><?= $this->Form->checkbox('alias', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Referral Earnings') ?></td>
                <td><?= $this->Form->checkbox('referral', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Link Statistics') ?></td>
                <td><?= $this->Form->checkbox('stats', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Quick Link Tool') ?></td>
                <td><?= $this->Form->checkbox('api_quick', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Mass Shrinker Tool') ?></td>
                <td><?= $this->Form->checkbox('api_mass', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Full Page Script Tool') ?></td>
                <td><?= $this->Form->checkbox('api_full', ['class' => 'switchButton']); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;"><?= __('Developers API Tool') ?></td>
                <td><?= $this->Form->checkbox('api_developer', ['class' => 'switchButton']); ?></td>
            </tr>
        </table>

        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>

<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replaceClass = 'text-editor';
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.dtd.$removeEmpty['span'] = false;
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.rawgit.com/olance/jQuery-switchButton/e8a0e7ce8d735bcf9d417a6d8922790eeefee35c/jquery.switchButton.js"></script>

<script>
    $("input.switchButton[type=checkbox]").switchButton({
        width: 50,
        height: 20,
        button_width: 25,
        on_label: '<?= __("Yes") ?>',
        off_label: '<?= __("No") ?>'
    });
</script>

<?php $this->end(); ?>
