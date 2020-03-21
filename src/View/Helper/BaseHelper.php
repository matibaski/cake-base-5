<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class BaseHelper extends Helper
{
    public $helpers = ['Html'];

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
    public function counterCard(string $title, float $counter, string $type = 'default', string $prefix = '', string $affix = '', string $color = 'primary', string $icon = 'far fa-question-circle')
    {
        $counter = number_format($counter, 0, '.', '\'');

        switch($type) {
            case 'progressbar':
                echo <<<EOL
                <div class="card border-left-$color shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-$color text-uppercase mb-1">$title</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">$prefix $counter $affix</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-$color" role="progressbar" style="width: $counter%" aria-valuenow="$counter" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="$icon fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                EOL;
                break;
            default:
                echo <<<EOL
                <div class="card border-left-$color shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-$color text-uppercase mb-1">$title</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$prefix $counter $affix</div>
                            </div>
                            <div class="col-auto">
                                <i class="$icon fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                EOL;
        }
    }

    /**
     * pieChart
     * 
     * @param  string $title
     * @param  array  $chartData
     * @return HTML
     */
    public function pieChart(array $chartData)
    {
        if(count($chartData) > 6) {
            echo __('Max. 6 options for the pie chart.');
            EOL;
            return;
        }

        $chartId = 'PieChart_' . uniqid();
        $labels = rtrim('"' . implode('","', array_keys($chartData)) . '",', ',');
        $entries = rtrim('"' . implode('","', $chartData) . '",', ',');
        $colorNames = [
            'primary',
            'success',
            'info',
            'warning',
            'danger',
            'secondary'
        ];
        $colorHex = [
            '#4e73df',
            '#1cc88a',
            '#36b9cc',
            '#f6c23e',
            '#e74a3b',
            '#858796'
        ];

        $i = 0;
        $colorHexOutput = '"';
        foreach($chartData as $number) {
            if($i >= count($colorHex)) {
                $i = 0;
            }
            $colorHexOutput .= $colorHex[$i] . '","';
            $i++;
        }
        $colorHexOutput = rtrim($colorHexOutput, '"');

        echo <<<EOL
        <div class="chart-pie pt-4 pb-2">
            <canvas id="$chartId"></canvas>
        </div>
        <div class="text-center mt-4 small">
        EOL;
        $i = 0;
        foreach($chartData as $label => $number) {
            if($i >= count($colorNames)) {
                $i = 0;
            }
            echo '<span class="mr-2">';
            echo '  <i class="fas fa-circle text-' . $colorNames[$i] . '"></i> ' . $label;
            echo '</span>';
            $i++;
        }
        echo <<<EOL
        </div>

        <script type="text/javascript" src="/plugins/chartjs/dist/Chart.min.js"></script>
        <script type="text/javascript">
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById("$chartId");
        var $chartId = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [$labels],
                datasets: [{
                    data: [$entries],
                    backgroundColor: [$colorHexOutput],
                    hoverBackgroundColor: [$colorHexOutput],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
        </script>
        EOL;
    }

    /**
     * areaChart
     * 
     * @param  string $title
     * @param  string $labelTitle
     * @param  string $prefix
     * @param  array  $chartData
     * @return HTML
     */
    public function areaChart(string $labelTitle, string $prefix = 'CHF', array $chartData)
    {
        $chartId = 'AreaChart_' . uniqid();
        $labels = rtrim('"' . implode('","', array_keys($chartData)) . '",', ',');
        $entries = rtrim('"' . implode('","', $chartData) . '",', ',');

        echo <<<EOL
            
            <canvas id="$chartId"></canvas>
            <script type="text/javascript" src="/plugins/chartjs/dist/Chart.min.js"></script>
            <script type="text/javascript">
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            var ctx = document.getElementById("$chartId");
            var myLineChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: [$labels],
                datasets: [{
                  label: "$labelTitle",
                  lineTension: 0.3,
                  backgroundColor: "rgba(78, 115, 223, 0.05)",
                  borderColor: "rgba(78, 115, 223, 1)",
                  pointRadius: 3,
                  pointBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointBorderColor: "rgba(78, 115, 223, 1)",
                  pointHoverRadius: 3,
                  pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                  pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                  pointHitRadius: 10,
                  pointBorderWidth: 2,
                  data: [$entries],
                }],
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'date'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 7
                    }
                  }],
                  yAxes: [{
                    ticks: {
                      maxTicksLimit: 5,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return '$prefix' + value.toLocaleString();
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }],
                },
                legend: {
                  display: false
                },
                tooltips: {
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  intersect: false,
                  mode: 'index',
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': $prefix' + tooltipItem.yLabel.toLocaleString();
                    }
                  }
                }
              }
            });
            </script>
        EOL;
    }
}