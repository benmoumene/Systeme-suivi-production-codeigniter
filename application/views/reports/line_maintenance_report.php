<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="refresh" content="30">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <style>
        table, td, th {
            border: 1px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 2px;
        }


        body {font-family: Arial, Helvetica, sans-serif;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        /*Loader Start*/
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
        /*Loader End*/
    </style>
</head>
<body>
<table id="" border="1" width="100%" style="border: 1px solid black;">
    <thead>
        <tr style="background-color: #f7ffb0;">
            <th align="center" style="font-size: 20px; font-weight: 900; width: 40px;">LINE</th>
            <th align="center" colspan="10" style="font-size: 20px; font-weight: 900; width: 40px;">Machine Info</th>
        </tr>
    </thead>
    <tbody>

    <?php

    foreach ($lines AS $k => $line){

        $line_id = $line['id'];

    ?>
        <tr style="font-size: 20px;">
            <td align="center"><?php echo $line['line_code']; ?></td>

            <?php

            $machine_maintenance_list = $this->method_call->getMachineMaintenanceReport($line_id, $h['start_time'], $h['end_time']);

            foreach ($machine_maintenance_list as $m){

                $start_time = strtotime($m['problem_start_date_time']);
                $now_time = strtotime($date_time);

                $hour = round((((($now_time - $start_time) / 60))), 2);

            ?>

                <td align="center" title="<?php echo $m['problem_start_date_time'];?>" onclick="">
                    <?php echo $m['machine_no'].' / '.$m['machine_name'].'('.$hour.' Min)';?>
                </td>

            <?php
                }
            ?>

        </tr>

    <?php

    }

    ?>

    </tbody>
</table>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="loader" class="loader" style="display: block;"></div>
        <div id="quality"></div>
    </div>

</div>


</body>
</html>