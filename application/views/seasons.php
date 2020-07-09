<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Seasons</h1>
          <h2 class="">Seasons...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Seasons</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
            </div>

          <a href="<?php echo base_url();?>access/add_season" class="btn btn-primary">NEW SEASON</a>

          <br />
<!--              <div class="col-md-3">-->
<!--                  <select class="form-control" required id="cut_no">-->
<!--                      <option>Search Cut No...</option>-->
<!--                      <option>1</option>-->
<!--                      <option>2</option>-->
<!--                  </select>-->
<!--              </div>-->
<!--              <br />-->
<!--              <br />-->
<!--              <br />-->
       <div class="porlets-content">

         <div class="table-responsive" style="overflow-x:auto;">
                <table class="display table table-bordered table-striped" id="">
                  <thead>
                    <tr>
                      <th class="hidden-phone center">SL No</th>
                      <th class="hidden-phone center">Season</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $sl = 1;

                      foreach ($seasons as $v) { ?>
                        <tr>
                            <td class="center"><?php echo $sl;?></td>
                            <td class="center"><?php echo $v['season'];?></td>
                            </td>
                        </tr>
                    <?php
                          $sl++;
                      }
                    ?>

                  </tbody>
                </table>
              </div><!--/table-responsive-->
              </div>
         
           </div><!--/porlets-content-->  
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>

<script type="text/javascript">
    $('select').select2();
</script>