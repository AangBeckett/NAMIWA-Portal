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

    //reveal child info
    let child = $("#childInfo");
    $("#yesParent").click(function () {
        child.show();
    });
    $("#noParent").click(function () {
        child.hide();
    });
    if (document.getElementById('yesParent').checked) {
        child.show();
    }
    if (document.getElementById('noParent').checked) {
        child.hide();
    }

    //reveal child diagnosis info
    let diagnosis = $("#diagnosisInfo");
    $("#yesDiagnosis").click(function () {
        diagnosis.show();
    });
    $("#noDiagnosis").click(function () {
        diagnosis.hide();
    });
    if (document.getElementById('yesDiagnosis').checked) {
        diagnosis.show();
    }
    if (document.getElementById('noDiagnosis').checked) {
        diagnosis.hide();
    }

    //reveal education info
    let ed = $("#edProgram");
    $("#noPublic").click(function () {
        ed.show();
    });
    $("#yesPublic").click(function () {
        diagnosis.hide();
    });
    if (document.getElementById('noPublic').checked) {
        ed.show();
    }
    if (document.getElementById('yesPublic').checked) {
        ed.hide();
    }

    //reveal grad year
    let grad = $("#grad");
    $("#yesGrad").click(function () {
        grad.show();
    });
    $("#noGrad").click(function () {
        grad.hide();
    });
    if (document.getElementById('yesGrad').checked) {
        grad.show();
    }
    if (document.getElementById('noGrad').checked) {
        grad.hide();
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