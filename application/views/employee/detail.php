  <?php
    $title_header = 'Employee Detail';
  ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart',
                type: 'bar',
                marginRight: 200,
                marginBottom: 25
            },
            title: {
                text: 'Attendance Graph <?=date("Y")?>',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember']
            },
            yAxis: {
                max : 100,
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            credits: {
                  enabled: false
              },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +' % ';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Total Attendance',
                data: [
                    <?php
                        for($i=1; $i<=12; $i++){ 
                            $data = $this->db->query("SELECT * FROM attendance WHERE id_employee='$id_employee' AND MONTH(attendance_date)='$i'")->result();
                            if($data){
                                $jml_row = count($data);
                            }else{
                                $jml_row = 0;
                            }
                            $jml = ($jml_row * 100) / 20;
                            echo $jml.',';
                        }
                     ?>
                ]
            },
            {
                name: 'Total On time',
                data: [
                    <?php
                        for($i=1; $i<=12; $i++){ 
                            $data = $this->db->query("SELECT * FROM attendance WHERE id_employee='$id_employee' AND MONTH(attendance_date)='$i' AND actual_in < '09:15:00'")->result();
                            if($data){
                                $jml_row = count($data);
                            }else{
                                $jml_row = 0;
                            }
                            $jml = ($jml_row * 100) / 20;
                            echo $jml.',';
                        }
                     ?>
                ]
            },
            {
                name: 'Total Late',
                data: [
                    <?php
                        for($i=1; $i<=12; $i++){ 
                            $data = $this->db->query("SELECT * FROM attendance WHERE id_employee='$id_employee' AND MONTH(attendance_date)='$i' AND actual_in > '09:15:00'")->result();
                            if($data){
                                $jml_row = count($data);
                            }else{
                                $jml_row = 0;
                            }
                            $jml = ($jml_row * 100) / 20;
                            echo $jml.',';
                        }
                     ?>
                ]
            }]
        });
    });
    
});
    </script>
<style type="text/css">
    input{width:100%;}
    select{width:103%;}
</style>
            <div class="container">
                <?=$this->session->flashdata('notifikasi')?>
                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4><?=$title_header;?></h4>
                            </div>
                            <div class="w-box-content">
                            <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br><br>