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
<link href="<?php echo base_url(); ?>assets/plugins/morris/morris.css" rel="stylesheet" />

<!--Select2 Start-->
<script src="<?php echo base_url(); ?>assets/select2/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/select2.min.js"></script>
<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet"/>
<!--Select2 End-->

    <!--Canvas Chart Asset Start-->
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
    <!--Canvas Chart Asset End-->

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

        div.scroll {
            /*background-color: #00FFFF;*/
            width: 1900px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll2 {
            /*background-color: #00FFFF;*/
            width: 1200px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll3 {
            /*background-color: #00FFFF;*/
            width: 850px;
            height: 500px;
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
            width: 400px;
            height: 300px;
            overflow: scroll;
        }

        /*table thead fixed*/
            .table-fixed thead {
                width: 100%;
            }
            .table-fixed tbody {
                height: 230px;
                overflow-y: auto;
                width: 100%;
            }
            .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
                display: block;
            }
            .table-fixed tbody td, .table-fixed thead > tr> th {
                float: left;
                border-bottom-width: 0;
            }
        /*table thead fixed*/

        .well1 {
            background: none;
            height: 400px;
        }

        .well {
            background: none;
            height: 600px;
        }

        .table-scroll tbody {
            position: absolute;
            overflow-y: scroll;
            height: 450px;
        }

        .table-scroll tr {
            width: 100%;
            table-layout: fixed;
            display: inline-table;
        }

        .table-scroll thead > tr > th {
            /*border: none;*/
        }
    </style>

</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<body class="light_theme  fixed_header atm-spmenu-push green_thm left_nav_hide">
<div class="wrapper">
  <!--\\\\\\\ wrapper Start \\\\\\-->
  <div class="header_bar">
    <!--\\\\\\\ header Start \\\\\\-->
    <div class="brand">
      <!--\\\\\\\ brand Start \\\\\\-->
      <div class="logo" style="display:block;">Reports</div>
      <div class="small_logo" style="display:none"><img src="<?php echo base_url(); ?>assets/images/s-logo.png" width="50" height="47" alt="s-logo" /> <img src="images/r-logo.png" width="122" height="20" alt="r-logo" /></div>
    </div>
    <!--\\\\\\\ brand end \\\\\\-->
    <div class="header_top_bar">
      <!--\\\\\\\ header top bar start \\\\\\-->
      <a href="javascript:void(0);" class="menutoggle"> <i class="fa fa-bars"></i> </a>
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
            <li><a href="<?php echo base_url();?>dashboard/"><i class="fa fa-home"></i> Dashboard <span class="left_nav_pointer"></span></a></li>
<!--            <li><a href="--><?php //echo base_url();?><!--dashboard/indexPc"><i class="fa fa-home"></i> 1st Floor <span class="left_nav_pointer"></span></a></li>-->
<!--            <li><a href="--><?php //echo base_url();?><!--dashboard/indexPc_2"><i class="fa fa-home"></i> 2nd Floor <span class="left_nav_pointer"></span></a></li>-->
            <li> <a href="javascript:void(0);"> <i class="fa fa-cut"></i> Cutting Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
              <ul>
<!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/dateWiseCuttingReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Date Wise Cutting</b> </a> </li>-->
<!--                  <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineWIPReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>WIP Report Graph</b> </a> </li>-->
                  <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/print_bundle_summary_page"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Bundle Summary</b> </a> </li>
                  <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/dailyPackageReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Package Report</b> </a> </li>
                  <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/package_ready_report"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Ready Summary </b> </a> </li>
                  <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/packageReadyByPO"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>PO Wise Package</b> </a> </li>
                  <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/cutPackageReportChart" target="_blank"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cutting Dashboard</b> </a> </li>
              </ul>
            </li>

            <li> <a href="javascript:void(0);"> <i class="fa fa-list-ul"></i> Line Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/cutVsOutpotReportByDateRange"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Cut Vs Output</b> </a> </li>-->

                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/linePerformanceDashboard"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Performance</b> </a> </li>
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineInputReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Report</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineInputReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Pass Report Graph</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineDefectReportChart"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Defect Report Graph</b> </a> </li>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineSummaryReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Summary Report</b> </a> </li>-->
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/allLinePerformanceDashboard"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Summary Report</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/lineHourlyReport" target="_blank"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Hourly Report</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/lineQualityReport" target="_blank"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Quality Report</b> </a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0);"> <i class="fa fa-archive"></i> Finishing Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/dateWiseWashSendReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Wash Send</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/dateWiseWashReturnReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Wash Return</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/finishingPerformanceDashboard"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Performance Report</b> </a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0);"> <i class="fa fa-cogs"></i> Maintenance Report <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" target="_blank" href="<?php echo base_url();?>dashboard/getLineWiseMaintenanceReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Line Maintenance</b> </a> </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0);"> <i class="fa fa-bar-chart-o"></i> Reports <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/dailyPerformanceReportNew"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Daily Performance</b> </a> </li>
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/poClosingReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>PO Closing Report</b> </a> </li>-->
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/shipDateWiseReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Ship Date Wise Report</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/shipDateWiseReportlive"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Ship Date Report Live</b> </a> </li>
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="--><?php //echo base_url();?><!--dashboard/shipDateWiseReportByMonth"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Monthly Ship Report</b> </a> </li>-->
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/shipDateWiseReportMonth"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Monthly Report</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/shipDateWiseReportBYDate"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Date Range Report</b> </a> </li>
<!--                    <li> <a style="margin-bottom: 1px;" href="--><?php //echo base_url();?><!--dashboard/shipDateWiseDailyProductionReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>PO Daily Report</b> </a> </li>-->
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/warehouseReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Warehouse Report</b> </a> </li>
                    <li> <a style="margin-bottom: 1px;" href="<?php echo base_url();?>dashboard/aqlReport"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>AQL Report</b> </a> </li>
                </ul>
            </li>

<!--            <li> <a href="javascript:void(0);"> <i class="fa fa-plus"></i> Backup <span class="plus"><i class="fa fa-plus"></i></span></a>-->
<!--                <ul>-->
<!--                    <li> <a style="margin-bottom: 1px;" target="_blank" href="http://10.234.15.250:81/pts_2018/dashboard/indexpc"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Backup 2018</b> </a> </li>-->
<!--                </ul>-->
<!--            </li>-->

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
