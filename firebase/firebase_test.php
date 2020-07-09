<?php
mysql_connect('localhost','root','');
mysql_select_db("efl_db_pts");

$today_date = date('Y-m-d');

$res = mysql_query("SELECT t1.*, t2.target, t3.line_output, t3.line_output_date
                    FROM `tb_line` as t1
                    
                    LEFT JOIN
                    `line_daily_target` as t2
                    ON t1.id=t2.line_id
                    
                    LEFT JOIN
                    (SELECT line_id, COUNT(pc_tracking_no) as line_output, 
                    DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') as line_output_date 
                    FROM `tb_care_labels` WHERE line_id !=0 AND access_points_status=4
                    AND DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d') LIKE '%$today_date%'
                    GROUP BY DATE_FORMAT(end_line_qc_date_time, '%Y-%m-%d'), line_id) as t3
                    ON t2.line_id=t3.line_id
                
                    WHERE t2.date LIKE '%$today_date%' AND t1.status=1
                    ORDER BY (t1.line_code * 1)");

while ($row_1 = mysql_fetch_array($res)){
    echo '<pre>';
    print_r($row_1);
    echo '</pre>';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Firebase Test</title>
</head>

<body>
<input type="text" name="mainText" id="mainText" />
<button id="submit_btn" onclick="submitClickNew();">Save</button>
<br />
<br />
<table border="1">
    <thead>
        <tr>
            <th>Line</th>
            <th>Target</th>
            <th>Output</th>
        </tr>
    </thead>
    <tbody id="line_data">

    </tbody>
</table>

<script src="https://www.gstatic.com/firebasejs/5.3.0/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDu8t83g0CD3ymNendCvFE-GwerJ22wicc",
        authDomain: "efl-pts.firebaseapp.com",
        databaseURL: "https://efl-pts.firebaseio.com",
        projectId: "efl-pts",
        storageBucket: "efl-pts.appspot.com",
        messagingSenderId: "651075960600"
    };
    firebase.initializeApp(config);
</script>

<script src="https://code.jquery.com/jquery-3.1.0.js"></script>

<script src="firebase_index.js"></script>

<script>
    $(document).ready(function () {


        setInterval(function(){
            $("#line_data").empty();

            var rootRef = firebase.database().ref().child("2018-07-30").child("Line");

            rootRef.on("child_added", snap => {
                var line = snap.key;
            var line_target = snap.child("Target").val();
            var line_output = snap.child("Output").val();

            console.log(snap.val());

            $("#line_data").append("<tr><td>"+ line +"</td><td>"+ line_target +"</td><td>"+ line_output +"</td></tr>");
        });

        }, 2000);

        setInterval(function(){
            location.reload();
        }, 10000);
    });

    function submitClickNew() {
        var mainText = document.getElementById("mainText");
        var submitBtn = document.getElementById("submit_btn");

        var firebaseRef = firebase.database().ref();

        // Example Start

//         firebaseRef.child("2018-07-30").child("Line").child("9").child("Target").set("550");
//         firebaseRef.child("2018-07-30").child("Line").child("9").child("Output").set("400");
//
//
//         firebaseRef.child("2018-07-30").child("Line").child("10").child("Target").set("550");
//         firebaseRef.child("2018-07-30").child("Line").child("10").child("Output").set("390");
//
//
//         firebaseRef.child("2018-07-30").child("Line").child("11").child("Target").set("550");
//         firebaseRef.child("2018-07-30").child("Line").child("11").child("Output").set("355");
//
//
//         firebaseRef.child("2018-07-30").child("Line").child("17").child("Target").set("550");
//         firebaseRef.child("2018-07-30").child("Line").child("17").child("Output").set("360");
//
//
//         firebaseRef.child("2018-07-30").child("Line").child("18").child("Target").set("550");
//         firebaseRef.child("2018-07-30").child("Line").child("18").child("Output").set("380");

        // Example End


        '<?php

            while ($row = mysql_fetch_array($res)){

        ?>'


        firebaseRef.child("<?php echo $today_date;?>").child("Line").child("<?php echo $row['line_code'];?>").child("Target").set("<?php echo $row['target'];?>");
        firebaseRef.child("<?php echo $today_date;?>").child("Line").child("<?php echo $row['line_code'];?>").child("Output").set("<?php echo $row['line_output'];?>");


        '<?php } ?>'

    }

</script>

</body>

</html>