

var mainText = document.getElementById("mainText");
var submitBtn = document.getElementById("submit_btn");

function submitClick() {
    var firebaseRef = firebase.database().ref();

    // Example Start

    // firebaseRef.child("2018-07-30").child("Line").child("9").child("Target").set("550");
    // firebaseRef.child("2018-07-30").child("Line").child("9").child("Output").set("400");
    //
    //
    // firebaseRef.child("2018-07-30").child("Line").child("10").child("Target").set("550");
    // firebaseRef.child("2018-07-30").child("Line").child("10").child("Output").set("390");
    //
    //
    // firebaseRef.child("2018-07-30").child("Line").child("11").child("Target").set("550");
    // firebaseRef.child("2018-07-30").child("Line").child("11").child("Output").set("355");
    //
    //
    // firebaseRef.child("2018-07-30").child("Line").child("17").child("Target").set("550");
    // firebaseRef.child("2018-07-30").child("Line").child("17").child("Output").set("360");
    //
    //
    // firebaseRef.child("2018-07-30").child("Line").child("18").child("Target").set("550");
    // firebaseRef.child("2018-07-30").child("Line").child("18").child("Output").set("380");

    // Example End



    firebaseRef.child("2018-07-30").child("Line").child("9").child("Target").set("550");
    firebaseRef.child("2018-07-30").child("Line").child("9").child("Output").set("400");


    firebaseRef.child("2018-07-30").child("Line").child("10").child("Target").set("550");
    firebaseRef.child("2018-07-30").child("Line").child("10").child("Output").set("390");


    firebaseRef.child("2018-07-30").child("Line").child("11").child("Target").set("550");
    firebaseRef.child("2018-07-30").child("Line").child("11").child("Output").set("355");


    firebaseRef.child("2018-07-30").child("Line").child("17").child("Target").set("550");
    firebaseRef.child("2018-07-30").child("Line").child("17").child("Output").set("360");


    firebaseRef.child("2018-07-30").child("Line").child("18").child("Target").set("550");
    firebaseRef.child("2018-07-30").child("Line").child("18").child("Output").set("380");

}


