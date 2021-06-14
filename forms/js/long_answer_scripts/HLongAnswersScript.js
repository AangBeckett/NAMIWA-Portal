$(document).ready(function () {
    //revealing the convict textarea
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

    //reveal vet info
    let vet = $("#vetInfo");
    $("#yesFamily").click(function () {
        vet.show();
    });
    $("#noFamily").click(function () {
        vet.hide();
    });
    if (document.getElementById('yesFamily').checked) {
        vet.show();
    }
    if (document.getElementById('noFamily').checked) {
        vet.hide();
    }


    //reveal coteach with
    let coteach = $("#coteach");
    $("#yesCoteach").click(function () {
        coteach.show();
    });
    $("#noCoteach").click(function () {
        coteach.hide();
    });
    if (document.getElementById('yesCoteach').checked) {
        coteach.show();
    }
    if (document.getElementById('noCoteach').checked) {
        coteach.hide();
    }

    //reveal teach where
    let where = $("#where");
    $("#yesWhere").click(function () {
        where.show();
    });
    $("#noWhere").click(function () {
        where.hide();
    });
    if (document.getElementById('yesWhere').checked) {
        where.show();
    }
    if (document.getElementById('noWhere').checked) {
        where.hide();
    }
});
