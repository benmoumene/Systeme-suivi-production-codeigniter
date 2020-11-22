<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<script src="<?php echo base_url(); ?>assets/js/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/css/jquery-1.9.0.js"></script>
<link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
<link href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_page.css" rel="stylesheet" />

<!--Select2 Start-->
<script src="<?php echo base_url(); ?>assets/select2/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/select2.min.js"></script>
<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet"/>

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

        div.scroll {
            /*background-color: #00FFFF;*/
            width: 1220px;
            height: 300px;
            overflow: scroll;
        }

        div.scroll2 {
            /*background-color: #00FFFF;*/
            width: 950px;
            height: 300px;
            overflow: scroll;
        }

        div.scroll3 {
            /*background-color: #00FFFF;*/
            width: 600px;
            height: 200px;
            overflow: scroll;
        }

        div.scroll4 {
            /*background-color: #00FFFF;*/
            width: 520px;
            height: 300px;
            overflow: scroll;
        }

        div.scroll5 {
            /*background-color: #00FFFF;*/
            width: 250px;
            height: 300px;
            overflow: scroll;
        }

        div.scroll6 {
            /*background-color: #00FFFF;*/
            width: 1300px;
            height: 300px;
            overflow: scroll;
        }

        div.scroll7 {
            /*background-color: #00FFFF;*/
            width: auto;
            height: 300px;
            overflow: scroll;
        }
    </style>
    <!--Select2 End-->

</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<body class="light_theme  fixed_header atm-spmenu-push green_thm left_nav_hide">
<div class="wrapper">
  <!--\\\\\\\ wrapper Start \\\\\\-->
  <div class="header_bar">
    <!--\\\\\\\ header Start \\\\\\-->
    <div class="brand">
      <!--\\\\\\\ brand Start \\\\\\-->
      <div class="logo" style="display:block;"><?php echo $user_description;?></div>
      <div class="small_logo" style="display:none"><img src="<?php echo base_url(); ?>assets/images/s-logo.png" width="50" height="47" alt="s-logo" /> <img src="images/r-logo.png" width="122" height="20" alt="r-logo" /></div>
    </div>
    <!--\\\\\\\ brand end \\\\\\-->
    <div class="header_top_bar">
      <!--\\\\\\\ header top bar start \\\\\\-->
      <a href="javascript:void(0);" class="menutoggle" id="nav_bar"> <i class="fa fa-bars"></i> </a>
      <div class="top_left">
        <div class="top_left_menu">
          <ul>
            <li> <a href="javascript:void(0);" onclick="window.location.reload(1);"> <i class="fa fa-repeat"></i> </a> </li>
<!--            <li> <a href="javascript:void(0);"> <i class="fa fa-th-large"></i> </a> </li>-->
          </ul>
        </div>
      </div>
      <!--<a href="javascript:void(0);" class="add_user" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square"></i> <span> New Task</span> </a>-->
      <div class="top_right_bar">
        <div class="top_right">
          <div class="top_right_menu">
            <!--<ul>
              <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"> Tasks <span class="badge badge">8</span> </a>
                <ul class="drop_down_task dropdown-menu">
                  <div class="top_pointer"></div>
                  <li>
                    <p class="number">You have 7 pending tasks</p>
                  </li>
                  <li> <a href="task.html" class="task">
                    <div class="green_status task_height" style="width:80%;"></div>
                    <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right green_label">80%</span> </div>
                    <div class="task_detail">Task details goes here</div>
                    </a> </li>
                  <li> <a href="task.html" class="task">
                    <div class="yellow_status task_height" style="width:50%;"></div>
                    <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right yellow_label">50%</span> </div>
                    <div class="task_detail">Task details goes here</div>
                    </a> </li>
                  <li> <a href="task.html" class="task">
                    <div class="blue_status task_height" style="width:70%;"></div>
                    <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right blue_label">70%</span> </div>
                    <div class="task_detail">Task details goes here</div>
                    </a> </li>
                  <li> <a href="task.html" class="task">
                    <div class="red_status task_height" style="width:85%;"></div>
                    <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right red_label">85%</span> </div>
                    <div class="task_detail">Task details goes here</div>
                    </a> </li>
                  <li> <span class="new"> <a href="task.html" class="pull_left">Create New</a> <a href="task.html" class="pull-right">View All</a> </span> </li>
                </ul>
              </li>
              <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"> Mail <span class="badge badge color_1">4</span> </a>
                <ul class="drop_down_task dropdown-menu">
                  <div class="top_pointer"></div>
                  <li>
                    <p class="number">You have 4 mails</p>
                  </li>
                      <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                  <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                  <li> <a href="readmail.html" class="mail red_color"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                  <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
              
                </ul>
              </li>
              <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"> notification <span class="badge badge color_2">6</span> </a>
                <div class="notification_drop_down dropdown-menu">
                  <div class="top_pointer"></div>
                  <div class="box"> <a href="inbox.html"> <span class="block primery_6"> <i class="fa fa-envelope-o"></i> </span> <span class="block_text">Mailbox</span> </a> </div>
                  <div class="box"> <a href="calendar.html"> <span class="block primery_2"> <i class="fa fa-calendar-o"></i> </span> <span class="block_text">Calendar</span> </a> </div>
                  <div class="box"> <a href="maps.html"> <span class="block primery_4"> <i class="fa fa-map-marker"></i> </span> <span class="block_text">Map</span> </a> </div>
                  <div class="box"> <a href="todo.html"> <span class="block primery_3"> <i class="fa fa-plane"></i> </span> <span class="block_text">To-Do</span> </a> </div>
                  <div class="box"> <a href="task.html"> <span class="block primery_5"> <i class="fa fa-picture-o"></i> </span> <span class="block_text">Tasks</span> </a> </div>
                  <div class="box"> <a href="timeline.html"> <span class="block primery_1"> <i class="fa fa-clock-o"></i> </span> <span class="block_text">Timeline</span> </a> </div>
                </div>
              </li>
            </ul>-->
          </div>
        </div>
        <div class="user_admin dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"><img src="<?php echo base_url();?>assets/images/favicon.ico" style="background: #ffffff; border-radius: 5px;"/><span class="user_adminname">Profile</span> <b class="caret"></b> </a>
          <ul class="dropdown-menu">
            <div class="top_pointer"></div>
            <li><span style="color:#006; font-size: 12px;"><b><?php echo $this->session->userdata('employee_name');?></b></span></li>
            <li> <a href="<?php echo base_url();?>access/change_password"><i class="fa fa-user"></i> Change Password </a> </li>
            <li> <a href="<?php echo base_url(); ?>access/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
          </ul>
        </div>
        <!--<a href="javascript:;" class="toggle-menu menu-right push-body jPushMenuBtn rightbar-switch"><i class="fa fa-comment chat"></i></a>-->
      </div>
    </div>
    <!--\\\\\\\ header top bar end \\\\\\-->
  </div>
  <!--\\\\\\\ header end \\\\\\-->
  <div class="inner">
    <!--\\\\\\\ inner start \\\\\\-->
    <div class="left_nav">
      <!--\\\\\\\left_nav start \\\\\\-->
      <!--<div class="search_bar"> <i class="fa fa-search"></i>
        <input name="" type="text" class="search" placeholder="Search Dashboard..." />
      </div>-->
      <div class="left_nav_slidebar">
        <ul>
            <li><a target="_blank" href="<?php echo base_url();?>dashboard/indexPc"><i class="fa fa-home"></i> DASHBOARD <span class="left_nav_pointer"></span></a></li>
<!--            <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Manage Master Data <span class="plus"><i class="fa fa-plus"></i></span></a>-->
<!--              <ul>-->
<!--                  <li> <a href="--><?php //echo base_url();?><!--access/company_list"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Company List</b> </a> </li>-->
<!--                  <li> <a href="--><?php //echo base_url();?><!--access/vehicle_codes"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Vehicle Cards</b> </a> </li>-->
<!--              </ul>-->
<!--            </li>-->
<!--            <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Upload Files <span class="plus"><i class="fa fa-plus"></i></span></a>-->
<!--              <ul>-->
<!--                  <li> <a href="--><?php //echo base_url();?><!--access/upload_in_out_file"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Upload File</b> </a> </li>-->
<!--              </ul>-->
<!--            </li>-->
<!--            <li> <a href="--><?php //echo base_url();?><!--access/process"><i class="fa fa-circle"></i> Process </a></li>-->
<!--            <li> <a href="--><?php //echo base_url();?><!--access/excelUpload"><i class="fa fa-circle"></i> Upload Excel - PO </a></li>-->
<!--            <li> <a href="--><?php //echo base_url();?><!--access/po_list"><i class="fa fa-circle"></i> PO List </a></li>-->

            <?php
            if($access_points == 1000){
            ?>
                <li> <a href="javascript:void(0);"> <i class="fa fa-exchange"></i> Change <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/changeExfactory"><i class="fa fa-circle"></i> Change ExFacDate </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/change_line"><i class="fa fa-circle"></i> Change Line </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/change_bundle_planned_line"><i class="fa fa-circle"></i> Bundle Change Line </a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-list"></i> PO Management <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/poSizeUpdate"><i class="fa fa-circle"></i> PO Update </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/po_manual_closing"><i class="fa fa-circle"></i> Manual Close/Reopen </a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-cut"></i> Cutting <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/search_care_label"><i class="fa fa-circle"></i> Search Care Label </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/active_print_label"><i class="fa fa-circle"></i> Active Print Label </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/delete_cutting"><i class="fa fa-circle"></i> Delete Cutting </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/poCuttingManualPackageAdjustment"><i class="fa fa-circle"></i> Package Adjustment </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/removePoPart"><i class="fa fa-circle"></i> Remove Part </a></li>
                    </ul>
                </li>

<!--                <li> <a href="--><?php //echo base_url();?><!--access/pc_manual_closing"><i class="fa fa-minus-circle"></i> Piece Manual Closing </a></li>-->
                <li> <a href="javascript:void(0);"> <i class="fa fa-archive"></i> Backup <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/backup_db"><i class="fa fa-circle"></i> Backup DB </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/autoDbBackup"><i class="fa fa-circle"></i> Prod. Summary </a></li>
                    </ul>
                </li>

                <li> <a href="<?php echo base_url();?>access/sms_file_upload_test"><i class="fa fa-cloud-upload"></i> Manual File Upload </a></li>

            <?php
            }

            if($access_points == 0){ ?>

                <li> <a href="javascript:void(0);"> <i class="fa fa-cut"></i> Cutting <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cutting_new"><i class="fa fa-circle"></i> Cutting New </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/group_po_item_making"><i class="fa fa-circle"></i> Group-PO-Item </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/poPartDetail"><i class="fa fa-circle"></i> Set Parts </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/removePoPart"><i class="fa fa-circle"></i> Remove Part </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/multiple_po_item_remain_qty_excel"><i class="fa fa-circle"></i> Export PO-Item EXCEL </a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-barcode"></i> Scan <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/lay_scan"><i class="fa fa-circle"></i> Lay Complete </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cut_scan"><i class="fa fa-circle"></i> Cut Complete </a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-print"></i> Print <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/po_cut_for_care_label"><i class="fa fa-circle"></i> Print Care Label </a></li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/reprintRequest"><i class="fa fa-circle"></i> Reprint Label </a></li>
                    </ul>
                </li>

                <li> <a href="javascript:void(0);"> <i class="fa fa-bar-chart-o"></i> Cutting Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <!--                  <li> <a href="--><?php //echo base_url();?><!--access/care_label_report"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent Report</b> </a> </li>-->
                        <!--                  <li> <a href="--><?php //echo base_url();?><!--access/care_label_report_new"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent To Prod.</b> </a> </li>-->
                        <!--                  <li> <a style="margin-bottom: 1px;" href="--><?php //echo base_url();?><!--access/sendingToProductionReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent To Prod.</b> </a> </li>-->
                        <!--                  <li> <a style="margin-bottom: 1px;" href="--><?php //echo base_url();?><!--access/sendingToProductionReportByPO"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL To Prod. By PO</b> </a> </li>-->
                        <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/cuttingTableWiseReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cut-Table Report</b> </a> </li>-->
                        <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/poWiseCuttingReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>PO-Wise Cutting</b> </a> </li>-->
                        <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/cuttingStockReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cutting Stock Report</b> </a> </li>-->
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/print_bundle_summary_page"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Bundle Summary </b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cutting_summary"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Cutting Summary </b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/print_input_ticket"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Get Input Ticket </b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/cutPackageReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Cutting Dashboard </b> </a> </li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-bar-chart-o"></i> PO Info <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/poInfoReport"><i class="fa fa-circle"></i> Date Wise PO </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/poSearchReport"><i class="fa fa-circle"></i> PO Search </a> </li>
                    </ul>
                </li>
                <li> </li>

            <?php }

            if($access_points == 1){
                    // access_point = 1 = cutting
            ?>

<!--            <li> <a href="--><?php //echo base_url();?><!--access/cutting"><i class="fa fa-circle"></i> Cutting </a></li>-->

<!--            <li> <a href="--><?php //echo base_url();?><!--access/po_list_for_cutting"><i class="fa fa-circle"></i> Create Bundle </a></li>-->
<!--            <li> <a href="--><?php //echo base_url();?><!--access/cut_line_distribution"><i class="fa fa-circle"></i> Cut-Line Distribution </a></li>-->


<!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_send_to_production"><i class="fa fa-circle"></i> Send to Prod. </a></li>-->

<!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_send_to_production_bundle"><i class="fa fa-circle"></i> Send Bundle to Prod. </a></li>-->

            <li> <a href="javascript:void(0);"> <i class="fa fa-barcode"></i> Scan <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/care_label_send_to_production_individual"><i class="fa fa-circle"></i> Piece Scan </a></li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/collar_cuff_send_to_production"><i class="fa fa-circle"></i> Bundle Scan </a></li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/package_send_to_sew"><i class="fa fa-circle"></i> Input to Sew </a></li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/lay_scan"><i class="fa fa-circle"></i> Lay Complete </a></li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cut_scan"><i class="fa fa-circle"></i> Cut Complete </a></li>
                </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-print"></i> Print <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/po_cut_for_care_label"><i class="fa fa-circle"></i> Print Care Label </a></li>
                </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-bar-chart-o"></i> Cutting Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <!--                  <li> <a href="--><?php //echo base_url();?><!--access/care_label_report"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent Report</b> </a> </li>-->
                    <!--                  <li> <a href="--><?php //echo base_url();?><!--access/care_label_report_new"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent To Prod.</b> </a> </li>-->
                    <!--                  <li> <a style="margin-bottom: 1px;" href="--><?php //echo base_url();?><!--access/sendingToProductionReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL Sent To Prod.</b> </a> </li>-->
                    <!--                  <li> <a style="margin-bottom: 1px;" href="--><?php //echo base_url();?><!--access/sendingToProductionReportByPO"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>CL To Prod. By PO</b> </a> </li>-->
                    <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/cuttingTableWiseReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cut-Table Report</b> </a> </li>-->
                    <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/poWiseCuttingReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>PO-Wise Cutting</b> </a> </li>-->
                    <!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/cuttingStockReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cutting Stock Report</b> </a> </li>-->
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/print_bundle_summary_page"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Bundle Summary </b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cutting_summary"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Cutting Summary </b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/print_input_ticket"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Get Input Ticket </b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/cutPackageReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b> Cutting Dashboard </b> </a> </li>
                </ul>
            </li>

            <li> </li>

            <?php
                }

            if($access_points == 2){
            // access_point = 2 = begining_of_line
            ?>
                <li> <a href="<?php echo base_url();?>access/care_label_input_line"><i class="fa fa-circle"></i> CL Input Line </a></li>
            <?php
                }

            if($access_points == 3){
            // access_point = 2 = begining_of_line
            ?>
<!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_mid_line"><i class="fa fa-circle"></i> Mid-Line QC</a></li>-->
            <li> <a href="<?php echo base_url();?>access/care_label_mid_line_new"><i class="fa fa-circle"></i> Mid-Line QC</a></li>
            <?php
            }

            if($access_points == 4){
            // access_point = 2 = begining_of_line
            ?>
<!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
            <li> <a href="<?php echo base_url();?>access/care_label_end_line_new"><i class="fa fa-circle"></i> End-Line QC</a></li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Line Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/linePerformanceDashboardNew/<?php echo $line_id;?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Dashboard</b> </a> </li>
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/dashboardReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Dashboard Report</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/linePerformanceDashboard"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Performance</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineInputReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Report</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineInputReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Pass Report Graph</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineWIPReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>WIP Report Graph</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineDefectReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Defect Report Graph</b> </a> </li>-->
                </ul>
            </li>
            <?php
            }

            if($access_points == 5){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/care_label_finishing"><i class="fa fa-circle"></i> Finishing QC</a></li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Line Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>access/lineInputReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Report</b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>access/lineInputReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Pass Report Graph</b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>access/lineWIPReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>WIP Report Graph</b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>access/lineDefectReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Defect Report Graph</b> </a> </li>
                    </ul>
                </li>
                <?php
            }

            if($access_points == 6){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/care_label_washing"><i class="fa fa-circle"></i> Wash Return</a></li>
                <?php
            }

            if($access_points == 7){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/care_label_packing"><i class="fa fa-circle"></i> Packing </a></li>
                <li> <a href="<?php echo base_url();?>access/finishing_alter"><i class="fa fa-circle"></i> Quality Control </a></li>
                <li> <a href="<?php echo base_url();?>access/print_sticker_test"><i class="fa fa-circle"></i> Sticker Test </a></li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Finishing Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/finishingFloorOutputReport/<?php echo $floor_id;?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Finishing Dashboard</b> </a> </li>
                    </ul>
                </li>
                <?php
            }

            if($access_points == 8){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/bundle_collar_cuff_track"><i class="fa fa-circle"></i> Collar Cuff Track </a></li>
<!--                <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Line Reports <span class="plus"><i class="fa fa-plus"></i></span></a>-->
<!--                    <ul>-->
<!--                        <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineInputReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Report</b> </a> </li>-->
<!--                        <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineInputReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Pass Report Graph</b> </a> </li>-->
<!--                        <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineWIPReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>WIP Report Graph</b> </a> </li>-->
<!--                        <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--access/lineDefectReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Defect Report Graph</b> </a> </li>-->
<!--                    </ul>-->
<!--                </li>-->
                <?php
            }
            if($access_points == 9){ ?>
                <li> <a href="<?php echo base_url();?>access/care_label_carton"><i class="fa fa-circle"></i> Carton </a></li>
            <?php
            }

            if($access_points == 10) { ?>
                <li><a href="<?php echo base_url(); ?>access/care_label_going_wash"><i class="fa fa-circle"></i> Wash Going </a></li>

                <?php
            }

            if($access_points == 100){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/wash"><i class="fa fa-circle"></i> Wash Control </a></li>
<!--                <li> <a href="--><?php //echo base_url();?><!--access/sms_file_upload"><i class="fa fa-circle"></i> SMS File Upload </a></li>-->
<!--                <li> <a href="--><?php //echo base_url();?><!--access/sms_file_upload_test"><i class="fa fa-circle"></i> Manual File Upload </a></li>-->

                <?php
            }

            if($access_points == 400){
                // access_point = 2 = begining_of_line
                ?>

                <li> <a href="<?php echo base_url();?>access/season"><i class="fa fa-circle"></i> Season </a></li>
                <li> <a href="<?php echo base_url();?>access/po_close_by_merchent"><i class="fa fa-circle"></i> PO Remarks </a></li>

                <?php
            }

            if($access_points == 200){
                // access_point = 2 = begining_of_line
                ?>
                <!--            <li> <a href="--><?php //echo base_url();?><!--access/care_label_end_line"><i class="fa fa-circle"></i> End-Line QC</a></li>-->
                <li> <a href="<?php echo base_url();?>access/outputControl"><i class="fa fa-list-ul"></i> Line Output Control </a></li>
                <li> <a href="<?php echo base_url();?>access/smv_form"><i class="fa fa-clock-o"></i> Set SMV </a></li>
                <li> <a href="<?php echo base_url();?>access/change_line"><i class="fa fa-exchange"></i> Change Line </a></li>
<!--                <li> <a href="--><?php //echo base_url();?><!--access/manage_bundle_line"><i class="fa fa-circle"></i> Bundle-Line </a></li>-->
<!--                <li> <a href="--><?php //echo base_url();?><!--access/washReport"><i class="fa fa-circle"></i> Wash Report </a></li>-->
                <li> <a href="<?php echo base_url();?>access/aqlPlan"><i class="fa fa-circle"></i> AQL Plan </a></li>
                <li> <a href="<?php echo base_url();?>access/unApproveRequest"><i class="fa fa-print"></i> Request Reprint </a></li>
                <li> <a href="<?php echo base_url();?>access/wash"><i class="fa fa-tint"></i> Wash Control </a></li>
                <li> <a href="<?php echo base_url();?>access/changeApprovedExfactory"><i class="fa fa-calendar" aria-hidden="true"></i> Approved Ship Date </a></li>
                <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Target Assign <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/cuttingTarget"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cutting Target</b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/finishingTarget"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Finishing Target</b> </a> </li>
                        <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>access/lineTarget"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Target</b> </a> </li>
                    </ul>
                </li>
                <?php
            }

            if($access_points == 300){
            ?>
                <li> <a href="<?php echo base_url();?>access/qa_warehouse_new"><i class="fa fa-circle"></i> QA Warehouse </a></li>
                <li> <a href="<?php echo base_url();?>access/other_purpose"><i class="fa fa-circle"></i> Other Purpose </a></li>
                <li> <a href="<?php echo base_url();?>access/aqlList"><i class="fa fa-circle"></i> AQL </a></li>
                <li> <a href="<?php echo base_url();?>access/packingList"><i class="fa fa-circle"></i> Packing List </a></li>
            <?php }

            if($access_points == 500){ ?>

                <li> <a href="<?php echo base_url();?>access/getReprintRequest"><i class="fa fa-circle"></i> Reprint Requests </a></li>

            <?php }

            if($access_points == 600){ ?>

                <li><a href="<?php echo base_url();?>access/getMachineList"><i class="fa fa-bars"></i> Machine List </a></li>
                <li><a href="<?php echo base_url();?>access/getMachineNames"><i class="fa fa-th"></i> Machine Names </a></li>
                <li><a href="<?php echo base_url();?>access/getMachineModels"><i class="fa fa-indent"></i> Machine Models </a></li>
                <li><a href="<?php echo base_url();?>access/getMachineBrands"><i class="fa fa-check-square"></i> Machine Brands </a></li>
                <li><a href="<?php echo base_url();?>access/getMachineLocations"><i class="fa fa-map-marker"></i> Locations </a></li>

            <?php } ?>

            <li> <a href="<?php echo base_url(); ?>access/logout"><i class="fa fa-power-off"></i> Logout</a> </li>
        </ul>
      </div>
    </div>
    <!--\\\\\\\left_nav end \\\\\\-->
    <div class="contentpanel">
      <!--\\\\\\\ contentpanel start\\\\\\-->
      <?php echo $maincontent;?>
    <!--\\\\\\\ content panel end \\\\\\-->
  </div>
  <!--\\\\\\\ inner end\\\\\\-->
</div>
<!--\\\\\\\ wrapper end\\\\\\-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
      </div>
      <div class="modal-body"> content </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- sidebar chats -->
<nav class="atm-spmenu atm-spmenu-vertical atm-spmenu-right side-chat">
	<div class="header">
    <input type="text" class="form-control chat-search" placeholder=" Search">
  </div>
  <div href="#" class="sub-header">
    <div class="icon"><i class="fa fa-user"></i></div> <p>Online (4)</p>
  </div>
  <div class="content">
    <p class="title">Family</p>
    <ul class="nav nav-pills nav-stacked contacts">
      <li class="online"><a href="#"><i class="fa fa-circle-o"></i> Steven Smith</a></li>
      <li class="online"><a href="#"><i class="fa fa-circle-o"></i> John Doe</a></li>
      <li class="online"><a href="#"><i class="fa fa-circle-o"></i> Michael Smith</a></li>
      <li class="busy"><a href="#"><i class="fa fa-circle-o"></i> Chris Rogers</a></li>
    </ul>
    
    <p class="title">Friends</p>
    <ul class="nav nav-pills nav-stacked contacts">
      <li class="online"><a href="#"><i class="fa fa-circle-o"></i> Vernon Philander</a></li>
      <li class="outside"><a href="#"><i class="fa fa-circle-o"></i> Kyle Abbott</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Dean Elgar</a></li>
    </ul>   
    
    <p class="title">Work</p>
    <ul class="nav nav-pills nav-stacked contacts">
      <li><a href="#"><i class="fa fa-circle-o"></i> Dale Steyn</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Morne Morkel</a></li>
    </ul>
    
  </div>
  <div id="chat-box">
    <div class="header">
      <span>Richard Avedon</span>
      <a class="close"><i class="fa fa-times"></i></a>    </div>
    <div class="messages nano nscroller has-scrollbar">
      <div class="content" tabindex="0" style="right: -17px;">
        <ul class="conversation">
          <li class="odd">
            <p>Hi John, how are you?</p>
          </li>
          <li class="text-right">
            <p>Hello I am also fine</p>
          </li>
          <li class="odd">
            <p>Tell me what about you?</p>
          </li>
          <li class="text-right">
            <p>Sorry, I'm late... see you</p>
          </li>
          <li class="odd unread">
            <p>OK, call me later...</p>
          </li>
        </ul>
      </div>
    <div class="pane" style="display: none;"><div class="slider" style="height: 20px; top: 0px;"></div></div></div>
    <div class="chat-input">
      <div class="input-group">
        <input type="text" placeholder="Enter a message..." class="form-control">
        <span class="input-group-btn">
        <button class="btn btn-danger" type="button">Send</button>
        </span>      </div>
    </div>
  </div>
</nav>
<!-- /sidebar chats -->






<!--<div class="demo"><span id="demo-setting"><i class="fa fa-cog txt-color-blueDark"></i></span> <form><legend class="no-padding margin-bottom-10" style="color:#6e778c;">Layout Options</legend><section><label><input type="checkbox" class="checkbox style-0" id="smart-fixed-header" name="subscription"><span>Fixed Header</span></label><label><input type="checkbox" class="checkbox style-0" id="smart-fixed-navigation" name="terms"><span>Fixed Navigation</span></label><label><input type="checkbox" class="checkbox style-0" id="smart-rigth-navigation" name="terms"><span>Right Navigation</span></label><label><input type="checkbox" class="checkbox style-0" id="smart-boxed-layout" name="terms"><span>Boxed Layout</span></label><span id="smart-bgimages" style="display: none;"></span></section><section><h6 class="margin-top-10 semi-bold margin-bottom-5">Clear Localstorage</h6><a id="reset-smart-widget" class="btn btn-xs btn-block btn-primary" href="javascript:void(0);"><i class="fa fa-refresh"></i> Factory Reset</a></section> <h6 class="margin-top-10 semi-bold margin-bottom-5">Ultimo Skins</h6><section id="smart-styles"><a style="background-color:#23262F;" class="btn btn-block btn-xs txt-color-white margin-right-5" id="dark_theme" href="javascript:void(0);"><i id="skin-checked" class="fa fa-check fa-fw"></i> Dark Theme</a><a style="background:#E35154;" class="btn btn-block btn-xs txt-color-white" id="red_thm" href="javascript:void(0);">Red Theme</a><a style="background:#34B077;" class="btn btn-xs btn-block txt-color-darken margin-top-5" id="green_thm" href="javascript:void(0);">Green Theme</a><a style="background:#56A5DB" class="btn btn-xs btn-block txt-color-white margin-top-5" data-skinlogo="img/logo-pale.png" id="blue_thm" href="javascript:void(0);">Blue Theme</a><a style="background:#9C6BAD" class="btn btn-xs btn-block txt-color-white margin-top-5" id="magento_thm" href="javascript:void(0);">Magento Theme</a><a style="background:#FFFFFF" class="btn btn-xs btn-block txt-color-black margin-top-5" id="light_theme" href="javascript:void(0);">Light Theme</a></section></form> </div>-->

</div>
</body>
</html>
<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jPushMenu.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/side-chats.js"></script>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form-components.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/dynamic_table_init.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/edit-table/edit-table.js"></script>
