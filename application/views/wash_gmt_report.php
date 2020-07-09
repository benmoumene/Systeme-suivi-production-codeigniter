<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Wash Report</h1>
        <h2 class="">Wash Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Wash Report</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Wash Report</h3>
            </div>
        </div>
        <div id="row">
            <div class="col-md-2">
                <div class="form-group">

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <h4>Select Date*</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="from_date" name="from_date" required />
                    <span>From Date *</span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="to_date" name="to_date" required />
                    <span>To Date *</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <span class="btn btn-success" onclick="getWashData();">Search</span>
                </div>
            </div>
        </div>

<input type="hidden" name="from_date_set" id="from_date_set" readonly />
<input type="hidden" name="to_date_set" id="to_date_set" readonly />

        <div class="row">
            <div class="col-md-12">

                <div class="porlets-content">
                    <button class="print_cl_btn" id="submit" onclick="printDiv('print_div');">PRINT</button>
                    <br />
                    <div id="table_content">


                    </div>
                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

<!--        <div id="print-btn"></div>-->

    </div><!--/col-md-12-->
</div>
<!--/row-->

<script type="text/javascript">
    $('select').select2();

        window.addEventListener('keydown', function(event) {
            if (event.keyCode === 80 && (event.ctrlKey || event.metaKey) && !event.altKey && (!event.shiftKey || window.chrome || window.opera)) {
                event.preventDefault();
                if (event.stopImmediatePropagation) {
                    event.stopImmediatePropagation();
                } else {
                    event.stopPropagation();
                }
                return;
            }
        }, true);

    function getWashData() {
        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

        var res1 = from_dt.split("-");
        var res2 = to_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

        $.ajax({
            url: "<?php echo base_url();?>access/getWashGoingReport/",
            type: "POST",
            data: {from_date: from_date, to_date: to_date},
            dataType: "html",
            success: function (data) {
//                console.log(data);

                $("#table_content").empty();
                $("#table_content").append(data);
                $("#loader").css("display", "none");

                $("#from_date_set").val(from_date);
                $("#to_date_set").val(to_date);
            }
        });

    }

    function printDiv(divName) {
        var from_date_set = $("#from_date_set").val();
        var to_date_set = $("#to_date_set").val();

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        $.ajax({
            url: "<?php echo base_url();?>access/updateWashPrintedPcs/",
            type: "POST",
            data: {from_date: from_date_set, to_date: to_date_set},
            dataType: "html",
            success: function (data) {
                console.log(data);
            }
        });

        document.getElementById('nav_bar').click();

//        location.reload();
    }


</script>