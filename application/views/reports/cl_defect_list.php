<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1><?php echo $heading_title?></h1>
            <h2 class=""><?php echo $heading_title?>...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active"><?php echo $heading_title?></li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">

    <div id="main-content">
        <div class="page-content">


            <div class="row">
                <div class="col-md-12">
                    <div class="block-web">
                        <div class="header">
                            <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                            <h3 class="content-header"><?php echo $heading_title?></h3>
                        </div>
                        <div class="porlets-content">
                            <div class="table-responsive">

                    <table class="display table table-bordered table-striped" id="">
                        <thead>
                            <tr>
                                <th class="center">SL</th>
                                <th class="center">Part Code</th>
                                <th class="center">Part Name</th>
                                <th class="center">Defect Type</th>
                                <th class="center">Defect Code</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl=1;

                        foreach ($cl_defect_report as $v){
                        $defect_part = $v['defect_part'];
                        $part_name = $v['part_name'];
                        $defect_code = $v['defect_code'];

                        ?>
                            <tr>
                                <td class="center"><?php echo $sl; $sl++;?></td>
                                <td class="center"><?php echo $defect_part?></td>
                                <td class="center"><?php echo $part_name?></td>
                                <td class="center"></td>
                                <td class="center"><?php echo $defect_code;?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    function getReportByPo(id) {
        var purchase_order_stuff = $("#"+id).val();

        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoWiseReportbyPo/",
            type: "POST",
            data: {purchase_order_stuff: purchase_order_stuff},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>