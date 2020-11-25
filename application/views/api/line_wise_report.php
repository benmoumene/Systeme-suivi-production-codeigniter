<html>

<head>
    <title>Firebase Test</title>
<!--    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--    <script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>-->

    <script src = "<?php echo base_url(); ?>assets/js/jquery.min.js""></script>
    <script src="<?php echo base_url(); ?>assets/firebase/firebase.js"></script>
</head>

<body>
<div id = "mydiv">
    Click on this to see a dialogue box.
</div>

<script type="text/javascript">
var firebaseConfig = {
apiKey: "AIzaSyDu8t83g0CD3ymNendCvFE-GwerJ22wicc",
authDomain: "efl-pts.firebaseapp.com",
databaseURL: "https://efl-pts.firebaseio.com",
projectId: "efl-pts",
storageBucket: "efl-pts.appspot.com",
messagingSenderId: "651075960600",
appId: "1:651075960600:web:cda37f85fab55e02"
};

firebase.initializeApp(firebaseConfig);

var database = firebase.database();

var cur_date = "<?php echo date('Y-m-d');?>";
var pre_date = "<?php echo date('Y-m-d', strtotime("-1 day"));;?>";

var previousDateRef = this.database.ref("EcoFab/" + pre_date + "/");
previousDateRef.remove();

function writeUserData(line, target, output, efficiency, dhu) {

    firebase.database().ref("EcoFab/" + cur_date + "/" + "Line/" + line).set({
        Target: target,
        Output: output,
        Efficiency: efficiency,
        DHU: dhu,
    });

}
</script>
</body>

<script type="text/javascript">
    $(document).ready(function() {
//        writeUserData("1st Floor", "Line-10", "600", "280", "27.45");

        setInterval(function(){

            window.open('', '_self', '').close();

        }, 60000);


            $.ajax({
                url: "<?php echo base_url();?>api/allLinePerformanceDashboard/",
                type: "POST",
                data: {date: cur_date},
                dataType: "json",
                success: function (data) {
                    var data_length = data.length;

                    console.log(data_length);

                    for(var i=0; data_length > i; i++){
                        var line_id = data[i].line_id;
                        var line_code = (data[i].line_code != null ? data[i].line_code : ' ');
                        var line_name = (data[i].line_name != null ? data[i].line_name : ' ');
                        var efficiency = (data[i].efficiency != null ? data[i].efficiency : 0);
                        var target = (data[i].target != null ? data[i].target : 0);
                        var total_output_qty = (data[i].total_output_qty != null ? data[i].total_output_qty : 0);
                        var dhu = (data[i].dhu != null ? data[i].dhu : 0);

                        console.log(line_id+' ~ '+line_code+' ~ '+efficiency+' ~ '+target+' ~ '+total_output_qty);
                        writeUserData(line_code, target, total_output_qty, efficiency, dhu);
                    }

                }
            });


    });
</script>

</html>



