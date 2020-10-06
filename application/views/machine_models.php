<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 20px;
        height: 20px;
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
          <h1>Machine Models</h1>
          <h2 class="">Machine Models...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Machine Models</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
          <div class="header">
              <div class="actions">
                  <div class="row">
                      <div class="col-md-8">
                          <div style="padding-top:10px">
                              <h6 style="color:red">
                                  <?php
                                  $exc = $this->session->userdata('exception');
                                  if (isset($exc)) {
                                      echo $exc;
                                      $this->session->unset_userdata('exception');
                                  }
                                  ?>
                              </h6>

                              <h6 style="color:green">
                                  <?php
                                  $msg = $this->session->userdata('message');
                                  if (isset($msg)) {
                                      echo $msg;
                                      $this->session->unset_userdata('message');
                                  }
                                  ?>
                              </h6>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="table-responsive">
                              <table class="display" id="">
                                  <thead>
                                  <tr>
                                      <!--                                <th class="hidden-phone center"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>-->
                                      <th class="hidden-phone center">
                                          <span class="btn btn-success" data-target="#myModal2" data-toggle="modal"><i class="fa fa-plus"></i> Machine Model</span>
                                      </th>
                                      <th class="hidden-phone center">
                                          <span class="btn btn-default" id="btnExport123" onclick="ExportToExcel('table_id')">
                                                <i class="fa fa-arrow-down"></i> <b> EXCEL</b>
                                          </span>
                                      </th>
                                  </tr>
                                  </thead>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="block-web" style="overflow-x:auto;">
              <table class="display table table-bordered table-striped" id="table_id" border="1">
                  <thead>
                      <tr style="font-size: 16px;">
                          <th class="hidden-phone center">SL.</th>
                          <th class="hidden-phone center">Machine Model</th>
                          <th class="hidden-phone center">Model Description</th>
                          <th class="hidden-phone center">Action</th>
                      </tr>
                  </thead>

                  <tbody id="table_body">
                  <?php

                  $sl=1;

                  foreach ($machine_models as $k => $v){ ?>

                      <tr>
                          <td class="center">
                              <?php echo $sl; $sl++;?>
                              <input type="hidden" readonly="readonly" id="machine_model_id_<?php echo $k;?>" value="<?php echo $v['id'];?>">
                          </td>
                          <td class="center">
                              <?php echo $v['machine_model'];?>
                              <input type="hidden" readonly="readonly" id="machine_model_<?php echo $k;?>" value="<?php echo $v['machine_model'];?>">
                          </td>
                          <td class="center">
                              <?php echo $v['machine_model_description'];?>
                              <input type="hidden" readonly="readonly" id="machine_model_description_<?php echo $k;?>" value="<?php echo $v['machine_model_description'];?>">
                          </td>
                          <td class="center">
                              <span class="btn btn-warning" title="EDIT" data-target="#myModal3" data-toggle="modal" onclick="getSetDataToModal(<?php echo $k;?>);"><i class="fa fa-edit"></i></span>
                          </td>
                      </tr>

                  <?php
                    }
                  ?>

                  </tbody>

              </table>
          </div>
      </div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">ADD MACHINE MODEL</h4>
            </div>
            <form action="<?php echo base_url();?>access/saveNewMachineModel" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label for="new_machine_model" class="col-form-label">Machine Model:</label>
                    <input type="text" class="form-control" id="new_machine_model" name="new_machine_model" autocomplete="off" required="required">
                </div>
                <div class="form-group">
                    <label for="new_machine_model_description" class="col-form-label">Machine Model Description:</label>
                    <input type="text" class="form-control" id="new_machine_model_description" name="new_machine_model_description" autocomplete="off">
                </div>

            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-primary" id="modal_submit_btn">SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">EDIT MACHINE MODEL</h4>
            </div>
            <form action="<?php echo base_url();?>access/updateMachineModel" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_machine_model" class="col-form-label">Machine Model:</label>
                        <input type="text" class="form-control" id="edit_machine_model" name="edit_machine_model" autocomplete="off" required="required">
                        <input type="hidden" class="form-control" id="edit_machine_model_id" name="edit_machine_model_id" autocomplete="off" required="required">
                    </div>
                    <div class="form-group">
                        <label for="edit_machine_model_description" class="col-form-label">Machine Model Description:</label>
                        <input type="text" class="form-control" id="edit_machine_model_description" name="edit_machine_model_description" autocomplete="off">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="submit" class="btn btn-primary" id="modal_submit_btn">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.select').select2();

    function getSetDataToModal(row){
        $("#edit_machine_model_id").val('');
        $("#edit_machine_model").val('');
        $("#edit_machine_model_description").val('');

        var machine_model_id = $("#machine_model_id_"+row).val();
        var machine_model = $("#machine_model_"+row).val();
        var machine_model_description = $("#machine_model_description_"+row).val();

        $("#edit_machine_model_id").val(machine_model_id);
        $("#edit_machine_model").val(machine_model);
        $("#edit_machine_model_description").val(machine_model_description);
    }
    
    function ExportToExcel(tableid) {
        var tab_text = "<table border='2px'><tr>";
        var textRange; var j = 0;
        tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
        if (tab==null) {
            return false;
        }
        if (tab.rows.length == 0) {
            return false;
        }

        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "download.xls");
        }
        else                 //other browser not tested on IE 11
        //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            try {
                var blob = new Blob([tab_text], { type: "application/vnd.ms-excel" });
                window.URL = window.URL || window.webkitURL;
                link = window.URL.createObjectURL(blob);
                a = document.createElement("a");
                if (document.getElementById("caption")!=null) {
                    a.download=document.getElementById("caption").innerText;
                }
                else
                {
                    a.download = 'download';
                }

                a.href = link;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            } catch (e) {
            }


        return false;
        //return (sa);
    }

</script>