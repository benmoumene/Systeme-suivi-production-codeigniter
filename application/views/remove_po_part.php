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
        <h1>Remove PO Parts</h1>
        <h2 class="">Remove PO Parts...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Remove PO Parts</li>
        </ol>
    </div>
</div>


<div class="row" style="padding-left: 10px">
    <div class="form-group">

        <div class="col-md-3">
            <div class="form-group">
                <select required type="text" class="form-control" id="po_no" name="po_no">

                    <option value="">Select PO No...</option>
                    <?php foreach ($sap_no as $v){ ?>
                        <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                    <?php } ?>
                </select>
                <span style="font-size: 11px;">* PO No.</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <button onclick="getPoParts()" class="btn btn-success" id="btn_submit">SEARCH</button>
            </div>
        </div>

        <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>

    </div>
</div>
<div class="row">
    <section class="panel default blue_title h2">

        <div class="panel-body">
            <div id="table_content">
                <div class="col-md-6 tableFixHead">


                    <table class="table table-bordered table-striped" id="" border="1">
                        <thead>
                        <tr>
                            <th class="hidden-phone center">SL</th>
                            <th class="hidden-phone center">Part Name</th>
                            <th class="hidden-phone center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>







<script type="text/javascript">
    $('select').select2();

    function getPoParts() {
        var po_no = $("#po_no").val();

        if(po_no != '') {
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>access/getPoParts/",
                type: "POST",
                data: {po_no: po_no},
                dataType: "html",
                success: function (data) {
                    $("#loader").css("display", "none");
                    $("#table_content").append(data);
                }
            });
        }else{
            alert("Please Select PO!");
        }
    }

    function deletePoPart(id, part_code) {
        var po_no = $("#po_no").val();

        var res = confirm("Are you sure to delete?");

        if(res == true){
            $.ajax({
                url: "<?php echo base_url();?>access/deletePoPart/",
                type: "POST",
                data: {part_id: id, part_code: part_code, po_no: po_no},
                dataType: "html",
                success: function (data) {

                    if(data == 'done'){
                        $("#loader").css("display", "none");
                        $("#btn_submit").click();
                    }

                }
            });
        }
    }
</script>