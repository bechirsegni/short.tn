<?php
$this->assign('title', __("Link Statistics"));
$this->assign('description', get_option('description'));
$this->assign('content_title', __("Link Statistics"));

?>

<h3 class="page-title"><?= __("Link Statistics") ?></h3>

<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img src="//api.webthumbnail.org/?width=400&height=300&screen=1366&url=<?= urlencode($link->url); ?>"
                     alt="<?= h($link->title); ?>" title="<?= h($link->title); ?>">
            </div>
            <div class="col-sm-7">
                <h3 class="page-header title"><?= $this->Html->link($link->title, $link->url); ?></h3>
                <p>
                    <small><?= $this->Text->autoLinkUrls($link->url, ['class' => 'text-muted']); ?></small>
                </p>
                <p><?= h($link->description); ?></p>
            </div>
            <div class="col-sm-2 text-center">
                <img alt="QR code"
                     src="//chart.googleapis.com/chart?cht=qr&amp;chs=150x150&amp;choe=UTF-8&amp;chld=H|0&amp;chl=<?= urlencode(get_short_url($link->alias,
                         $link->domain)); ?>">
            </div>
        </div>
    </div>
</div>

<hr>

<div class="box box-info wow fadeInUp">
    <div class="box-header">
        <i class="glyphicon glyphicon-stats"></i>
        <h3 class="box-title"><?= __("Clicks on last 30 days") ?></h3>
    </div>
    <div class="box-body">
        <div class="chart" id="last-month-hits" style="position: relative; height: 300px; width: 100%;"></div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<hr>

<div class="box box-success wow fadeInUp">
    <div class="box-header">
        <h3 class="box-title"><?= __("Countries") ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <div id="countries_geochart" style="position: relative; height: 300px; width: 100%;"></div>
            </div>
            <div class="col-sm-4" style="height: 300px;overflow: auto;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><?= __("Country") ?></th>
                        <th><?= __("Clicks") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($countries as $country) : ?>
                        <tr>
                            <td><?= $country->country ?></td>
                            <td><?= $country->clicks ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php unset($country); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="box box-success wow fadeInUp">
    <div class="box-header">
        <h3 class="box-title"><?= __("Referrers") ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th><?= __("Domain") ?></th>
                        <th><?= __("Clicks") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($referrers as $referrer) : ?>
                        <tr>
                            <td><?= $referrer->referer_domain ?></td>
                            <td><?= $referrer->clicks ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php unset($referrer); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php $this->start('scriptBottom'); ?>

<link rel="stylesheet" href="//cdn.rawgit.com/almasaeed2010/AdminLTE/v2.3.3/plugins/morris/morris.css">
<script src="//cdn.rawgit.com/DmitryBaranovskiy/raphael/v2.1.0/raphael-min.js"></script>
<script src="//cdn.rawgit.com/almasaeed2010/AdminLTE/v2.3.3/plugins/morris/morris.min.js"
        type="text/javascript"></script>

<script>

    jQuery(document).ready(function () {
        new Morris.Line({
            element: 'last-month-hits',
            resize: true,
            data: [
                <?php
                $last30days = array();
                for ($i = 30; $i > 0; $i--) {
                    $last30days[date('d-m-Y', strtotime('-' . $i . ' days'))] = 0;
                }
                foreach ($stats as $stat) {
                    if (empty($stat->statDateCount)) {
                        $stat->statDateCount = 0;
                    }
                    $last30days[$stat->statDate] = $stat->statDateCount;
                }

                foreach ($last30days as $key => $value) {
                    $date = date("Y-m-d", strtotime($key));
                    echo '{date: "' . $date . '", clicks: ' . $value . '},';
                }
                ?>
            ],
            xkey: 'date',
            xLabels: 'day',
            ykeys: ['clicks'],
            labels: ['Clicks'],
            lineWidth: 2,
            hideHover: 'auto',
            smooth: false
        });

    });
</script>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type='text/javascript'>
    google.load('visualization', '1', {'packages': ['geochart']});
    google.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
            ['Country', 'Clicks'],
            <?php
            foreach ($countries as $country) {
                echo '["' . $country->country . '", ' . $country->clicks . '],';
            }
            ?>
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('countries_geochart'));
        chart.draw(data, options);
    }
    ;
</script>

<?php $this->end(); ?>
