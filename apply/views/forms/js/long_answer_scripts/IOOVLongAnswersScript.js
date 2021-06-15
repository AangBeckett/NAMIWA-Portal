$(document).ready(function() {

    //slider
    var slider = document.getElementById("comfortable");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }

    //reveal convict text if yes is checked
    let convict = $("#convictText");
    $("#yesConvict").click(function () {
        convict.show();
    });
    $("#noConvict").click(function () {
        convict.hide();
    });
    if (document.getElementById('yesConvict').checked) {
        convict.show();
    }
    if (document.getElementById('noConvict').checked) {
        convict.hide();
    }

    //if hospitalized, how recently?
    let hospitalized = $("#recentlyText");
    $("#yesHospitalized").click(function () {
        hospitalized.show();
    });
    $("#noHospitalized").click(function () {
        hospitalized.hide();
    });
    if (document.getElementById('yesHospitalized').checked){
        hospitalized.show();
    }
    if (document.getElementById('noHospitalized').checked){
        hospitalized.hide();
    }

});
