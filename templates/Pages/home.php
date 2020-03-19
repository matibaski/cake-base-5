<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Navigation[]|\Cake\Collection\CollectionInterface $navigations
 */
$headerLinks = [];
$loadScripts = [
    '/plugins/chartjs/dist/Chart.min.js'
];

$this->assign('header_title_top', 'Dashboard');
$this->assign('header_links', serialize($headerLinks));
$this->assign('load_scripts', serialize($loadScripts));
?>
<!-- Content Row -->
<div class="row">

    <?php 
    /**
     * counterCard
     * 
     * @param  string $title
     * @param  float  $counter
     * @param  string $type
     * @param  string $prefix
     * @param  string $affix
     * @param  string $color
     * @param  string $icon
     * @return HTML
     */
    ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <?= $this->Base->counterCard(
            'Earnings (Monthly)',
            4000,
            'default',
            'CHF',
            '',
            'primary',
            'far fa-question-circle'
        ) ?>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <?= $this->Base->counterCard(
            'Earnings (Annual)',
            215000,
            'default',
            'CHF',
            '',
            'success',
            'fas fa-dollar-sign'
        ) ?>
        </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <?= $this->Base->counterCard(
            'Tasks',
            50,
            'progressbar',
            '',
            '%',
            'info',
            'fas fa-clipboard-list'
        ) ?>
        </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <?= $this->Base->counterCard(
            'Pending Requests',
            44,
            'default',
            '',
            '',
            'warning',
            'fas fa-comments'
        ) ?>
    </div>
    <div class="col-12 mb-4">
        <div class="card p-3">
            To use this Helper:<br />
            <pre class="m-0">&lt;?php echo $this->Base->counterCard($title, $counter, $type, $prefix, $affix, $color, $icon); ?></pre>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <?php 
                    $earnings = [
                        'Jan' => 0,
                        'Feb' => 10000,
                        'Mar' => 5000,
                        'Apr' => 15000,
                        'May' => 10000,
                        'Jun' => 20000,
                        'Jul' => 15000,
                        'Aug' => 25000,
                        'Sep' => 20000,
                        'Oct' => 30000,
                        'Nov' => 25000,
                        'Dec' => 40000
                    ];
                    ?> 
                    <?= $this->Base->areaChart(
                        'Earnings',
                        'CHF',
                        $earnings
                    ) ?>
                </div>
            </div>
            <div class="card-footer">
                To use this Helper:<br />
                <pre class="m-0">&lt;?php echo $this->Base->areaChart('Label', 'CHF', array($chartData)); ?></pre>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
            </div>
            <div class="card-body">
                <?= $this->base->pieChart(
                    [
                        'Direct' => 55,
                        'Social' => 130,
                        'Referral' => 115
                    ]
                ); ?>
            </div>
            <div class="card-footer">
                To use this Helper:<br />
                <pre class="m-0">&lt;?php echo $this->Base->pieChart(array($chartData)); ?></pre>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Color System -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Primary
                        <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Success
                        <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Info
                        <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="/img/undraw_posting_photo.svg" alt="">
                </div>
                <p>Add some quality, svg illustrations to your project courtesy of unDraw, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>
            </div>
        </div>

    </div>
</div>