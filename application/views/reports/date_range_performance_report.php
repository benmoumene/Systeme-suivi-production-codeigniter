<?php
$cur_date = date('Y-m-d');
$date_range = date('Y-m-d',(strtotime ( '-90 day' , strtotime ( $cur_date) ) ));
?>
<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Date Range Performance Report</h1>
        <h2 class="">Date Range Performance Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Date Range Performance Report</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
<!--                <h3 class="content-header">Daily Performance Report</h3>-->
            </div>
        </div>
        <div id="row">
            <div class="col-md-2">
                <div class="form-group">

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="department" name="department">
                        <option value="">Select Department</option>
                        <option value="cutting">Cutting</option>
                        <option value="sewing">Sewing</option>
                        <option value="finishing">Finishing</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="from_date" autocomplete="off" placeholder="From Date" name="from_date" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="to_date" autocomplete="off" placeholder="To Date" name="to_date" />
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" onclick="getDateRangeSummaryReport();">Search</button>
            </div>
            <div class="col-md-2">
                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 center">

                <div class="col-md-2"></div>
                <div class="col-md-10">
                <div class="porlets-content center" id="report_content" style="width: 75%">


                </div>
                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

    </div><!--/col-md-12-->
</div>
<!--/row-->

<script type="text/javascript">
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getDateRangeSummaryReport(){
        var department = $("#department").val();
        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

        if(department != '' && from_dt != '' && to_dt != ''){

            var res1 = from_dt.split("-");
            var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];

            var res2 = to_dt.split("-");
            var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

            $("#report_content").empty();

            if((from_date <= to_date)){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>dashboard/getDateRangeSummaryReport/",
                    type: "POST",
                    data: {from_date: from_date, to_date: to_date, department: department},
                    dataType: "html",
                    success: function (data) {
                        $("#report_content").append(data);
                        $("#loader").css("display", "none");
                    }
                });
            }else{
                alert('Invalid Date Range!');
            }


        }else{
            alert('Please Required Fields!');
        }

    }
</script>