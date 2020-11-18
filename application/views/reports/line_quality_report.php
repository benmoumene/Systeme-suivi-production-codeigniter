<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--    <meta http-equiv="refresh" content="30">-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />

    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

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
<br />
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h4 class="text-right">
                Select Date:
            </h4>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control" name="date_from" id="date_from"/>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control" name="date_to" id="date_to"/>
        </div>
        <div class="col-md-2">
            <span class="btn btn-success" onclick="getDateRangeQualityReport();">SEARCH</span>
        </div>
        <div class="col-md-1" id="loader" style="display: none;">
            <div class="loader"></div>
        </div>
    </div>
</div>

<br />
<table id="" border="1" width="100%" style="border: 1px solid black;">
        <thead>
            <tr style="background-color: #f7ffb0;">
                <th align="center" style="font-size: 16px; font-weight: 900;">DATE</th>
                <th align="center" style="font-size: 16px; font-weight: 900;">LINE</th>
                <th align="center" style="font-size: 16px; font-weight: 900;">DHU</th>

            <?php foreach ($defect_types AS $d){ ?>
                <th align="center" style="font-size: 16px; font-weight: 900;"><?php echo $d['defect_name']?></th>
            <?php } ?>
                <th align="center" style="font-size: 16px; font-weight: 900;">Total</th>
            </tr>
        </thead>
        <tbody id="table_content">

        <?php

        foreach ($lines AS $k => $line){

            $total_defects = 0;
        ?>
        <tr>
            <td align="center"><?php echo $date; ?></td>
            <td align="center"><?php echo $line['line_code']; ?></td>
            <td align="center">
                <?php
//                echo round($line['sum_of_dhu']/$hour, 2);
                ?>
                <?php echo $line['dhu']; ?>
            </td>

            <?php
                foreach ($defect_types AS $d){

                    $defect_count_res = $this->method_call->getDefectCount($line['id'], $d['defect_code'], $date);

                    $count_defect = ($defect_count_res[0]['count_defect'] != '' ? $defect_count_res[0]['count_defect'] : 0);

                    $total_defects += $count_defect;

            ?>
                <td align="center"><?php echo $count_defect;?></td>
            <?php } ?>
            <td align="center">
                <?php echo $total_defects; ?>
            </td>

        </tr>

        <?php

        }

        ?>

        </tbody>

</table>

<!-- The Modal -->

</body>
</html>

<script type="text/javascript">

    function getDateRangeQualityReport() {
        var from_date = $("#date_from").val();
        var to_date = $("#date_to").val();


        if(from_date != '' & to_date != '' && to_date >= from_date){
            $("#loader").css("display", "block");
            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getDateRangeQualityReport/",
                type: "POST",
                data: {from_date: from_date, to_date: to_date},
                dataType: "html",
                success: function (data) {
                    $("#table_content").append(data);
                    $("#loader").css("display", "none");
                }
            });
        }else{
            alert('Invalid Date Range!');
        }


    }

</script>