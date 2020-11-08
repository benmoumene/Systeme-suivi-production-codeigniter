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
          <h1>Machine List</h1>
          <h2 class="">Machine List...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Machine List</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
          <div class="header">
              <div class="actions">
                  <div class="row">
                      <div class="col-md-2">
                          <select required class="form-control" id="machine_no" name="machine_no">
                              <option value="">Machine No.</option>

                              <?php foreach ($machine_nos as $mno){ ?>
                                  <option value="<?php echo $mno['machine_no']?>"><?php echo $mno['machine_no'];?></option>
                              <?php } ?>

                          </select>
                      </div>
                      <div class="col-md-2">
                          <select required class="form-control" id="machine_name" name="machine_name">
                              <option value="">Machine Name</option>

                              <?php foreach ($machine_names as $mname){ ?>
                                  <option value="<?php echo $mname['id']?>"><?php echo $mname['machine_name'];?></option>
                              <?php } ?>

                          </select>
                      </div>
                      <div class="col-md-2">
                          <select required class="form-control" id="model" name="model">
                              <option value="">Machine Model</option>

                              <?php foreach ($machine_models as $mmodel){ ?>
                                  <option value="<?php echo $mmodel['id']?>"><?php echo $mmodel['machine_model'];?></option>
                              <?php } ?>

                          </select>
                      </div>
                      <div class="col-md-1">
                          <select required class="form-control" id="brand" name="brand">
                              <option value="">Brand</option>

                              <?php foreach ($machine_brands as $mbrand){ ?>
                                  <option value="<?php echo $mbrand['id']?>"><?php echo $mbrand['brand'];?></option>
                              <?php } ?>

                          </select>
                      </div>
                      <div class="col-md-1">
                          <select required class="form-control" id="line_id" name="line_id">
                              <option value="">Line</option>
                              <?php foreach ($lines as $l){ ?>
                                  <option value="<?php echo $l['id']?>"><?php echo $l['line_code'];?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-2">
                          <select class="form-control" id="other_location" name="other_location">
                              <option value="">Select Other Location</option>
                              <?php foreach ($other_locations as $ol){ ?>
                                  <option value="<?php echo $ol['id']?>"><?php echo $ol['location_name'];?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-1 text-right">
                          <span class="btn btn-primary" onclick="filterMachineList();">SEARCH</span>
                      </div>
                      <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>

                  </div>
              </div>
          </div>
          <br />
          <div class="block-web">
              <div class="row">
                  <div class="col-md-11"></div>
                  <div class="col-md-1">
                      <div class="table-responsive">
                          <table class="" id="">
                              <thead>
                                  <tr>
                                      <th class="hidden-phone center">
                                          <span class="btn btn-warning" id="btnExport123" onclick="ExportToExcel('table_id')">
                                                <i class="fa fa-arrow-down"></i> <b> EXCEL</b>
                                          </span>
                                      </th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
              </div>
              <br />
              <table class="display table table-bordered table-striped" id="table_id" border="1">
                  <thead>
                      <tr style="font-size: 16px;">
                          <th class="hidden-phone center">SL.</th>
                          <th class="hidden-phone center">Machine No</th>
                          <th class="hidden-phone center">Machine Name</th>
                          <th class="hidden-phone center">Model</th>
                          <th class="hidden-phone center">Brand</th>
                          <th class="hidden-phone center">Line</th>
                          <th class="hidden-phone center">Other Location</th>
                          <th class="hidden-phone center">Status</th>
                          <th class="hidden-phone center">Service Status</th>
                      </tr>
                  </thead>

                  <tbody id="table_body">
                  <?php

                  $sl=1;

                  foreach ($machine_list as $k => $v){ ?>

                      <tr>
                          <td class="center">
                              <?php echo $sl; $sl++;?>
                              <input type="hidden" required="required" readonly="readonly" id="machine_id_<?php echo $k;?>" value="<?php echo $v['id'];?>">
                          </td>
                          <td class="center"><?php echo $v['machine_no'];?></td>
                          <td class="center"><?php echo $v['machine_name'];?></td>
                          <td class="center"><?php echo $v['machine_model'];?></td>
                          <td class="center"><?php echo $v['brand'];?></td>
                          <td class="center"><?php echo $v['line_code'];?></td>
                          <td class="center"><?php echo $v['location_name'];?></td>
                          <td class="center"><?php echo ($v['status'] == 1 ? 'ACTIVE' : ($v['status'] == 0 ? 'INACTIVE' : '') );?></td>
                          <td class="center">
                              <?php
                              if($v['service_status'] == 0){
                                 echo 'Out of Service';
                              }
                              if($v['service_status'] == 1){
                                  echo 'Running';
                              }
                              if($v['service_status'] == 2){
                                  echo 'Under Maintenance';
                              }
                              if($v['service_status'] == 3){
                                  echo 'Idle';
                              }
                              ?>
                          </td>
                      </tr>

                  <?php
                    }
                  ?>

                  </tbody>

              </table>
          </div>
      </div>


<script type="text/javascript">
    $('select').select2();

    function filterMachineList() {
        var machine_no = $("#machine_no").val();
        var machine_name = $("#machine_name").val();
        var model = $("#model").val();
        var brand = $("#brand").val();
        var line_id = $("#line_id").val();
        var other_location = $("#other_location").val();

        $("#table_body").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/filterMachineList/",
            type: "POST",
            data: {machine_no: machine_no, machine_name: machine_name, model: model, brand: brand, line_id: line_id, other_location: other_location},
            dataType: "html",
            success: function (data) {
                $("#table_body").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function checkMachineAvailability() {
        var new_machine_no = $("#new_machine_no").val();

        $.ajax({
            url: "<?php echo base_url();?>access/checkMachineAvailability/",
            type: "POST",
            data: {new_machine_no: new_machine_no},
            dataType: "json",
            success: function (data) {

                console.log(data.length);

                if(data.length > 0){
                   $("#modal_submit_btn").attr('disabled', true);
               }else{
                   $("#modal_submit_btn").attr('disabled', false);
               }

            }
        });

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