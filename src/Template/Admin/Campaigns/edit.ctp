<?php
$this->assign('title', __('Edit Campaign'));
$this->assign('description', '');
$this->assign('content_title', __('Edit Campaign'));

?>

<?php
$interstitial_price = get_option('interstitial_price');
$countries = get_countries(true);

?>

<div class="box box-primary">
    <div class="box-body">
        <?= $this->Form->create($campaign, ['id' => 'campaign-create']); ?>

        <label><?= $this->Form->checkbox('default_campaign') ?> <?= __('Default Campaign') ?></label>
        <span class="help-block"><?= __('Default means that campaign will not count earning for publisher.') ?></span>

        <?=
        $this->Form->input('user_id', [
            'label' => __('User'),
            'options' => $users,
            'empty' => __('Choose'),
            'class' => 'form-control'
        ]);

        ?>

        <?=
        $this->Form->input('name', [
            'label' => __('Campaign Name'),
            'class' => 'form-control'
        ]);

        ?>

        <?=
        $this->Form->input('status', [
            'label' => __('Status'),
            'options' => [
                1 => __('Active'),
                2 => __('Paused'),
                3 => __('Canceled'),
                4 => __('Finished'),
                5 => __('Under Review'),
                6 => __('Pending Payment'),
                7 => __('Invalid Payment'),
                8 => __('Refunded')
            ],
            'empty' => __('Choose'),
            'class' => 'form-control'
        ]);

        ?>

        <?php if ($campaign->ad_type == 1 || $campaign->ad_type == 3) : ?>
            <legend><?= __('Website Details') ?></legend>

            <?=
            $this->Form->input('website_title', [
                'label' => __('Website Title'),
                'class' => 'form-control'
            ]);

            ?>

            <?=
            $this->Form->input('website_url', [
                'label' => __('Website URL'),
                'class' => 'form-control',
                'type' => 'url'
            ]);

            ?>

        <?php endif; ?>

        <?php if ($campaign->ad_type == 2) : ?>
            <legend><?= __('Banner Details') ?></legend>

            <?=
            $this->Form->input('banner_name', [
                'label' => __('Banner Name'),
                'class' => 'form-control'
            ]);

            ?>
            <span class="help-block"><?= __('(only for internal use)') ?></span>

            <?=
            $this->Form->input('banner_size', [
                'label' => __('Banner Size'),
                'options' => [
                    '728x90' => __('Leaderboard - 728x90'),
                    '468x60' => __('Full banner - 468x60'),
                    '336x280' => __('Large rectangle - 336x280')
                ],
                'empty' => __('Choose'),
                'class' => 'form-control'
            ]);

            ?>

            <?=
            $this->Form->input('banner_code', [
                'label' => __('Banner Code'),
                'class' => 'form-control',
                'type' => 'textarea'
            ]);

            ?>
            <span class="help-block"><?= __('(can be either HTML or JavaScript and must comply with our rules)') ?></span>

        <?php endif; ?>

        <legend><?= __('Advertising Rates') ?></legend>

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?= __('Country') ?></th>
                <th><?= __('Advertiser Price / 1,000') ?></th>
                <th><?= __('Publisher Price / 1,000') ?></th>
                <th><?= __('Purchase') ?></th>
            </tr>
            </thead>

            <?php foreach ($campaign->campaign_items as $key => $campaign_item) : ?>
                <tr>
                    <td>
                        <?= $this->Form->hidden("campaign_items.$key.id"); ?>
                        <?php
                        /*
                        echo $this->Form->input("campaign_items.$key.country", [
                            'label' => false,
                            'class' => 'form-control'
                        ]);
                        */
                        ?>
                        <pre><?= $campaign_item->country ?></pre>
                    </td>
                    <td>
                        <?php //echo $this->Form->hidden("campaign_items.$key.advertiser_price"); ?>
                        <pre><?= $campaign_item->advertiser_price ?></pre>
                    </td>
                    <td>
                        <?=
                        $this->Form->input("campaign_items.$key.publisher_price", [
                            'label' => false,
                            'class' => 'form-control',
                            'type' => 'text'
                        ]);

                        ?>
                    </td>
                    <td>
                        <?php //echo $this->Form->hidden("campaign_items.$key.purchase"); ?>
                        <pre><?= $campaign_item->purchase ?></pre>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?=
        $this->Form->input('traffic_source', [
            'label' => __('Traffic Sources'),
            'options' => [
                '1' => __('Desktop and Mobile'),
                '2' => __('Desktop'),
                '3' => __('Mobile')
            ],
            'empty' => __('Choose'),
            'class' => 'form-control'
        ]);

        ?>

        <?= $this->Form->button(__('Update Campaign'), ['class' => 'btn btn-success btn-lg']); ?>
        <?= $this->Form->end(); ?>
    </div><!-- /.box-body -->
</div>



