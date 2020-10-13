<div class="block-web">

  <div class="porlets-content">

      <div class="table-responsive">
          <table class="display table table-bordered table-striped" id="">
              <thead>
                  <tr>
                      <th class="hidden-phone center">Machine No</th>
                      <th class="hidden-phone center">Machine Name</th>
                      <th class="hidden-phone center">Machine Model</th>
                      <th class="hidden-phone center">Issue Date</th>
                      <th class="hidden-phone center">Status</th>
                  </tr>
              </thead>
              <tbody>
              <?php foreach($machine_maintenance AS $mc){ ?>
                  <tr>
                      <td class="hidden-phone center"><?php echo $mc['machine_no']?></td>
                      <td class="hidden-phone center"><?php echo $mc['machine_name']?></td>
                      <td class="hidden-phone center"><?php echo $mc['machine_model']?></td>
                      <td class="hidden-phone center"><?php echo $mc['problem_start_date_time']?></td>
                      <td class="hidden-phone center"><?php echo 'Under Maintenance'?></td>
                  </tr>
              <?php } ?>
              </tbody>
          </table>
      </div><!--/table-responsive-->
  </div>

</div>