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
          <h1>Locations</h1>
          <h2 class="">Locations...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Locations</li>
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
                                          <span class="btn btn-success" data-target="#myModal2" data-toggle="modal"><i class="fa fa-plus"></i> Location</span>
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
                          <th class="hidden-phone center">Location</th>
                          <th class="hidden-phone center">Description</th>
                          <th class="hidden-phone center">Action</th>
                      </tr>
                  </thead>

                  <tbody id="table_body">
                  <?php

                  $sl=1;

                  foreach ($locations as $k => $v){ ?>

                      <tr>
                          <td class="center">
                              <?php echo $sl; $sl++;?>
                              <input type="hidden" readonly="readonly" id="location_id_<?php echo $k;?>" value="<?php echo $v['id'];?>">
                          </td>
                          <td class="center">
                              <?php echo $v['location_name'];?>
                              <input type="hidden" readonly="readonly" id="location_name_<?php echo $k;?>" value="<?php echo $v['location_name'];?>">
                          </td>
                          <td class="center">
                              <?php echo $v['location_description'];?>
                              <input type="hidden" readonly="readonly" id="location_description_<?php echo $k;?>" value="<?php echo $v['location_description'];?>">
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
                <h4 class="modal-title" id="myModalLabel">ADD LOCATION</h4>
            </div>
            <form action="<?php echo base_url();?>access/saveNewLocation" method="POST">
            <div class="modal-body">

                <div class="form-group">
                    <label for="new_location_name" class="col-form-label">Location Name:</label>
                    <input type="text" class="form-control" id="new_location_name" name="new_location_name" autocomplete="off" required="required">
                </div>
                <div class="form-group">
                    <label for="new_machine_model_description" class="col-form-label">Location Description:</label>
                    <input type="text" class="form-control" id="new_machine_model_description" name="new_location_description" autocomplete="off">
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
                <h4 class="modal-title" id="myModalLabel">EDIT LOCATION</h4>
            </div>
            <form action="<?php echo base_url();?>access/updateLocation" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="edit_location_name" class="col-form-label">Location Name:</label>
                        <input type="text" class="form-control" id="edit_location_name" name="edit_location_name" autocomplete="off" required="required">
                        <input type="hidden" class="form-control" id="edit_location_id" name="edit_location_id" autocomplete="off" required="required">
                    </div>
                    <div class="form-group">
                        <label for="edit_location_description" class="col-form-label">Location Description:</label>
                        <input type="text" class="form-control" id="edit_location_description" name="edit_location_description" autocomplete="off">
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
        $("#edit_location_id").val('');
        $("#edit_location_name").val('');
        $("#edit_location_description").val('');

        var location_id = $("#location_id_"+row).val();
        var location_name = $("#location_name_"+row).val();
        var location_description = $("#location_description_"+row).val();

        $("#edit_location_id").val(location_id);
        $("#edit_location_name").val(location_name);
        $("#edit_location_description").val(location_description);
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