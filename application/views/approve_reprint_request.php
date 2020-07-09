<div class="pull-left breadcrumb_admin clear_both" xmlns="http://www.w3.org/1999/html">
    <div class="pull-left page_title theme_color">
        <h1>Approve Request</h1>
        <h2 class="">Approve Request...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Request</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Approve Request</h3>
            </div>


            <br class="porlets-content">




            <div class="row">
                <div class="form-group">

                </div>
            </div>

            <div class="row" style="text-align: left">
                <div class="form-group">

                        <div class="col-lg-4">
                            <button type="submit" id="save_btn" class="btn btn-primary"onclick="approveRequest()">Approve Request</button>
                        </div>

                </div>
            </div>

            <div class="porlets-content">

                <div class="table-responsive">
                    <table class="display table table-bordered table-striped" id="table_data">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"/>ID</th>
                            <th class="center">Care Label No.</th>
                            <th class="center">Po-NO</th>
                            <th class="center">Purchase Order</th>
                            <th class="center">Item</th>
                            <th class="center">Quality</th>
                            <th class="center">Color</th>
                            <th class="center">Brand</th>
                            <th class="center">Reprint Reason</th>
                            <th class="center">Requested By</th>


                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($get_req as $v_get_req){?>

                        <tr>

                            <td><input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $v_get_req['pc_tracking_no']?>"></td>
                            <td class="center"><?php echo $v_get_req['pc_tracking_no']?></td>
                            <td class="center"><?php echo $v_get_req['po_no']?></td>
                            <td class="center"><?php echo $v_get_req['purchase_order']?></td>
                            <td class="center"><?php echo $v_get_req['item']?></td>
                            <td class="center"><?php echo $v_get_req['quality']?></td>
                            <td class="center"><?php echo $v_get_req['color']?></td>
                           <td class="center"><?php echo $v_get_req['brand']?></td>
                            <td class="center"><?php echo $v_get_req['reprint_reason']?></td>
                            <td class="center"><?php echo $v_get_req['referenced_by']?></td>


                           </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div><!--/table-responsive-->
            </div>


            <!--                </form>-->
        </div><!--/porlets-content-->
    </div><!--/block-web-->
</div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('select').select2();

    $(document).on('click','#checkAll',function () {
        $('.checkItem').not(this).prop('checked', this.checked);
    });


    function approveRequest()
    {

        var pc_nos = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            pc_nos.push(sThisVal);

        });

        if(pc_nos !='')
        {
            $.ajax({
                url:"<?php echo base_url('access/approveRequest')?>",
                type:"post",
                dataType:"html",
                data:{pc_nos:pc_nos},
                success:function (data) {
                    if(data == 'done'){
                        alert('Approve Request Successful!!');
                        location.reload(true);
                    }
                }
            });
        }

    }


</script>