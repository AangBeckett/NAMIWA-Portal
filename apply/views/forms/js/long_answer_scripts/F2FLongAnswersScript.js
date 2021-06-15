$(document).ready(function() {
    //revealing the convict textarea
    let convict = $("#convictText");
    $("#yesConvict").click(function()
    {
        convict.show();
    });
    $("#noConvict").click(function()
    {
        convict.hide();
    });
    if(document.getElementById('yesConvict').checked)
    {
        convict.show();
    }
    if(document.getElementById('noConvict').checked)
    {
        convict.hide();
    }

    //reveal coteach with
    let coteach = $("#coTeachWith");
    $("#yesCoTeach").click(function () {
        coteach.show();
    });
    $("#noCoTeach").click(function () {
        coteach.hide();
    });
    if (document.getElementById('yesCoTeach').checked) {
        coteach.show();
    }
    if (document.getElementById('noCoTeach').checked) {
        coteach.hide();
    }

    //reveal teach where
    let where = $("#teachWhere");
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
