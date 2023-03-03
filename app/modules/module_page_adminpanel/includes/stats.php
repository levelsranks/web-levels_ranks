<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Admin_stats')?></h5>
        </div>
        <div class="card-block">
            <div class="card-container">
                <div class="row">
                    <div class="col-md-6">
                      <?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Total')?> <b><?=number_format($Chart_Visits['Visits_All'], 0, '.', ' ' )?></b><br>
                      <?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_For')?> <?=date('Y')?>: <b><?=number_format($Chart_Visits['Visits_Year'], 0, '.', ' ' )?></b>
                    </div>
                </div>
                <?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Online')?> <b><?=number_format($Chart_Visits['Online'], 0, '.', ' ' )?></b>
                <br>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
          type: 'line',
          data: {
            labels: [<?=$Chart_Visits['Date']?>],
            datasets: [{
                label: "<?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Visits')?>",
                backgroundColor: [
                  'rgb(103, 199, 255)',
                ],
                borderColor: [
                  'rgb(103, 199, 255)',
                ],
                borderWidth: 2,
                data: [<?=$Chart_Visits['Visits']?>]
              }
            ]
          },
          options: {
            responsive: true
          }
        });
</script>