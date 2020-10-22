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
        <h1>Daily Performance Report</h1>
        <h2 class="">Daily Performance Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Daily Performance Report</li>
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
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="search_date" placeholder="Select Date" name="search_date" />
                    <input type="hidden" class="form-control" id="date_range" readonly name="date_range" value="<?php echo $date_range; ?>" />
                    <input type="hidden" class="form-control" id="today_date" readonly name="today_date" value="<?php echo $cur_date; ?>" />
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" onclick="getDailySummaryReport();">Search</button>
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

    function getDailySummaryReport(){
        var department = $("#department").val();
        var search_dt = $("#search_date").val();
        var date_range = $("#date_range").val();
        var today_date = $("#today_date").val();

        var res1 = search_dt.split("-");

        var search_date = res1[2]+'-'+res1[0]+'-'+res1[1];

        $("#report_content").empty();
        if(search_date != '' && search_date != 'undefined--undefined'){
            if((search_date > date_range) && (search_date < today_date)){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>dashboard/getDailySummaryReportByDate/",
                    type: "POST",
                    data: {date: search_date, department: department},
                    dataType: "html",
                    success: function (data) {
                        $("#report_content").append(data);
                        $("#loader").css("display", "none");
                    }
                });
            }
            if(search_date == today_date){

                    $("#loader").css("display", "block");

                    $.ajax({
                        url: "<?php echo base_url();?>dashboard/getDailyReportByDateToday/",
                        type: "POST",
                        data: {date: search_date, department: department},
                        dataType: "html",
                        success: function (data) {
                            $("#report_content").append(data);
                            $("#loader").css("display", "none");
                        }
                    });
            }
            if(search_date <= date_range) {
                alert("Please Select Date More Than: "+ date_range);
            }

        }

    }
</script>