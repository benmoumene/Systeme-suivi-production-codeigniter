<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Group SO Reform</h1>
        <h2>Group SO Reform</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Group SO Reform</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="porlets-content">

                <form action="<?php echo base_url();?>access/makeGroupPoItem" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="block-web">

                                <div class="porlets-content">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <select class="form-control" name="group_so[]" id="group_so" onchange="getIndividualSoList();">
                                                    <option value="">Group SO</option>
                                                    <?php foreach ($so_list as $s){ ?>
                                                          <option value="<?php echo $s['po_no'];?>"><?php echo $s['po_no'];?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                                <br />
                                                <span><b>* Group SO </b></span>
                                            </div>
                                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                                        </div>
                                    </div>

                                    <br />

                                    <div id="print_div">
                                        <div class="row">
                                            <div id="table_content">
                                                <div class="col-md-12 tableFixHead">
                                                    <table class="table table-bordered table-striped" id="" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th class="hidden-phone center">Group SO</th>
                                                                <th class="hidden-phone center">SO</th>
                                                                <th class="hidden-phone center">Purchase Order</th>
                                                                <th class="hidden-phone center">Item</th>
                                                                <th class="hidden-phone center">Quality</th>
                                                                <th class="hidden-phone center">Color</th>
                                                                <th class="hidden-phone center">Style</th>
                                                                <th class="hidden-phone center">Style Name</th>
                                                                <th class="hidden-phone center">Brand</th>
                                                                <th class="hidden-phone center">Order</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('select').select2();

    function getIndividualSoList(id) {
        var group_so = $("#group_so").val();

        if(group_so != ''){

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>access/getIndividualSoList/",
                type: "POST",
                data: {group_so: group_so},
                dataType: "html",
                success: function (data) {
                    $("#table_content").append(data);
                }
            });
        }else{
            alert("Please Select Group SO!");
        }
    }
    
    function reformGroupSo() {
        var group_so = $("#group_so").val();

        if(group_so != ''){

            var confirm_alert = confirm("Are you Sure to Reform Group SO ?");

            if(confirm_alert == true){
                $.ajax({
                    url: "<?php echo base_url();?>access/reformGroupSo/",
                    type: "POST",
                    data: {group_so: group_so},
                    dataType: "html",
                    success: function (data) {
                        if(data == 'done'){
                            window.location="<?php echo base_url();?>access/group_po_item_making";
                        }
                    }
                });
            }

        }else{
            alert("Please Select Group SO!");
        }
    }
</script>