<?php
global $f3;

if (!empty($_POST)) {
    // get data from form
    $convict = $_POST['convict'];
    $convictText = $_POST['convictText'];
    $familyMember = $_POST['familyMember'];
    $relationship = $_POST['relationship'];
    $diagnosis = $_POST['diagnosis'];
    $takenF2F = $_POST['takenF2F'];
    $whyHomefrontTeacher = $_POST['whyHomefrontTeacher'];
    $coteach = $_POST['coteach'];
    $coteachWith = $_POST['coteachWith'];
    $knowWhere = $_POST['knowWhere'];
    $teachWhere = $_POST['teachWhere'];

    if ($convict == 'no') {
        $convictText = 'N/A';
    }

    if ($coteach == 'no') {
        $coteachWith = 'N/A';
    }

    if ($knowWhere == 'no') {
        $teachWhere = 'N/A';
    }

    //add data to hive
    $f3->set('convict', $convict);
    $f3->set('convictText', $convictText);
    $f3->set('familyMember', $familyMember);
    $f3->set('relationship', $relationship);
    $f3->set('diagnosis', $diagnosis);
    $f3->set('takenF2F', $takenF2F);
    $f3->set('whyHomefrontTeacher', $whyHomefrontTeacher);
    $f3->set('coteach', $coteach);
    $f3->set('coteachWith', $coteachWith);
    $f3->set('knowWhere', $knowWhere);
    $f3->set('teachWhere', $teachWhere);

    $_SESSION['LongAnswer'] = new HLongAnswers($convict, $convictText, $familyMember, $relationship, $diagnosis, $takenF2F,
        $whyHomefrontTeacher, $coteach, $coteachWith, $knowWhere, $teachWhere);

    if (validHLongAnswersForm()) {
        if ($_POST['goToReview'] == true) {
            $f3->reroute('/review');
        }

        $f3->reroute('/not_required');
    }
}

if (!isset($_SESSION['LongAnswer'])) {
    $_SESSION['LongAnswer'] = new HLongAnswers('', '', '', '', '', '',
        '', '', '', '', '');
}
