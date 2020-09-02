<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 25px;
        height: 25px;
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
<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Line Output Control</h1>
            <h2 class="">Line Output Control...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Line Output Control</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="line_no" name="line_no">
                            <option value="">Select Line...</option>
                            <?php
                                foreach ($lines as $l){ ?>
                                    <option value="<?php echo $l['id'];?>"><?php echo $l['line_name'];?></option>
                            <?php
                                }
//                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select Line</span>
                    </div>
                </div>

                <div class="col-md-1">
                    <span class="btn btn-success" id="search_btn" onclick="getReportByLine('line_no');">Search</span>
                </div>

                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>

                </div>
            </div>
        </div>
        <br />
        <div class="row" id="report_content"></div>

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-3 scroll4">
                            <div class="porlets-content">
                                <div class="table-responsive" id="remain_cl_list">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>

                </div>
            </div>
        </div>
    <!--\\\\\\\ container  end \\\\\\-->

<script type="text/javascript">
    $('select').select2();

    $(document).on('click','#checkAll',function () {
        $('.checkItem').not(this).prop('checked', this.checked);
    });

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getReportByLine(id) {
        var line_no = $("#"+id).val();

        if(line_no != ''){
            $("#loader").css("display", "block");

            $("#report_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>access/getLineWiseRunningPOs/",
                type: "POST",
                data: {line_no: line_no},
                dataType: "html",
                success: function (data) {
                    $("#report_content").append(data);
                    $("#loader").css("display", "none");
                }
            });
        }else {
            alert('Please Select Line!');
        }

    }
    
    function allowPOsToOutput() {
        var line_no = $("#line_no").val();

        var so_nos = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            so_nos.push(sThisVal);

        });

        if(line_no != ''){
            if(so_nos.length > 0){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>access/allowDenyLinePoOutput/",
                    type: "POST",
                    data: {status: 1, so_nos: so_nos, line_no: line_no},
                    dataType: "html",
                    success: function (data) {
                        if(data == 'done'){
                            location.reload();
                        }
                    }
                });

            }else {
                alert("Please Select POs!");
            }
        }else{
            alert("Please Select Line!");
        }

    }

    function denyPOsToOutput() {
        var line_no = $("#line_no").val();

        var so_nos = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            so_nos.push(sThisVal);

        });

        if(line_no != ''){
            if(so_nos.length > 0){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>access/allowDenyLinePoOutput/",
                    type: "POST",
                    data: {status: 0, so_nos: so_nos, line_no: line_no},
                    dataType: "html",
                    success: function (data) {
                        if(data == 'done'){
                            location.reload();
                        }
                    }
                });
            }else {
                alert("Please Select POs!");
            }
        }else{
            alert("Please Select Line!");
        }

    }

</script>