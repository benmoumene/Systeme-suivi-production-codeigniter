<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1><?php echo $title;?></h1>
        <h2 class=""><?php echo $title;?>...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active"><?php echo $title;?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions">

                    <div class="row">
                        <div class="col-md-1">
                            <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                        </div>
                    </div>

<!--                <h3 class="content-header">Daily Performance Report</h3>-->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 center" id="tableWrap">

                <div class="col-md-12">
                <div class="porlets-content center" id="report_content" style="width: 100%">

                    <table class="table table-bordered" border="1">
                        <thead>
                        <tr>
                            <th colspan="5" class="center" style="background-color: #5d6155; color: #FFFFFF;"><h2><?php echo $title;?></h2></th>
                            <th colspan="5" class="center" style="background-color: #5d6155; color: #FFFFFF;"><h2>Planned Line: <?php echo $plan_line;?></h2></th>
                        </tr>
                        <tr>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">SO</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Brand</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Purchase Order</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Item</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Quality</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Color</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Style No</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Style Name</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">ExFac Date</th>
                            <th class="center" style="font-size: 20px; font-weight: 900;background-color: #f7ffb0;">Ready Qty</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $total_qty = 0;

                        foreach ($ready_package_pos as $p){

                            $so_no = $p['so_no'];
                            $brand = $p['brand'];
                            $purchase_order = $p['purchase_order'];
                            $item = $p['item'];
                            $quality = $p['quality'];
                            $color = $p['color'];
                            $ex_factory_date = $p['ex_factory_date'];
                            $style_no = $p['style_no'];
                            $style_name = $p['style_name'];
                            $ready_qty = $p['ready_qty'];

                            $total_qty += $ready_qty;

                            ?>
                            <tr>
                                <td class="center" style="font-size: 20px;"><?php echo $so_no;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $brand;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $purchase_order;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $item;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $quality;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $color;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $style_no;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $style_name;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $ex_factory_date;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $ready_qty;?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td align="right" colspan="9" style="font-size: 20px; font-weight: 900;">TOTAL</td>
                                <td class="center" style="font-size: 20px; font-weight: 900;"><?php echo $total_qty;?></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

    </div><!--/col-md-12-->
</div>
<!--/row-->

<script type="text/javascript">

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

</script>