<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Add Season</h1>
          <h2 class="">Add Season...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li><a href="<?php echo base_url();?>access/season">Seasons</a></li>
              <li class="active">Add Season</li>
          </ol>
        </div>
      </div>

    <form action="<?php echo base_url();?>access/addingSeason" method="post">
        <div class="container clear_both padding_fix">
            <!--\\\\\\\ container  start \\\\\\-->
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <h4 align="right">New Season</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input class="form-control" type="text" name="season" id="season" autocomplete="off" onblur="isSeasonExist();" />
                                <br />
                                <span style="color: red;" id="er_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" disabled id="save_btn">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function isSeasonExist() {
        $("#report_content").empty();

        $("#er_msg").empty();

        var season = $("#season").val();

        if(season != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/isSeasonExist/",
                type: "POST",
                data: {season: season},
                dataType: "json",
                success: function (data) {
                    if(data.length > 0){
                        $("#save_btn").attr("disabled", true);
                        $("#er_msg").text("Already Exist!");
                    }else{
                        $("#save_btn").attr("disabled", false);
                        $("#er_msg").empty();
                    }
                }
            });
        }

    }
</script>