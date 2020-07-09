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
        <h1>Fusing Report</h1>
        <h2 class="">Fusing Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Fusing Report</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                    <h3 class="content-header"></h3>
                </div>
                <div class="porlets-content">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="date" name="date" required autocomplete="off" />
                                </div>
                                <span><b>* Select Date </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getFusingReport();">Search</button>
                            </div>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>

                    <br />
                    <br />
                    <br />
                    <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
                    <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                    <br />
                    <div id="print_div">
                        <div class="col-md-12" id="table_content" style="overflow-x:auto;">

                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#table_content').html())
            location.href=url
            return false
        })
    })

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }

    function getFusingReport() {
        var dt = $("#date").val();

        var res2 = dt.split("-");

        var date = res2[2]+'-'+res2[0]+'-'+res2[1];

        $("#table_content").empty();

        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getFusingReport/",
            type: "POST",
            data: {date: date},
            dataType: "html",
            success: function (data) {
                $("#table_content").append(data);
                $("#loader").css("display", "none");
            }
        });
    }


</script>