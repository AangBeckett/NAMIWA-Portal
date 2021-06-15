<?php
global $f3;

if(!empty($_POST))
{
    // get data from form
    $convict = $_POST['convict'];
    $convictText = $_POST['convictText'];
    $firstDegreeFamily = $_POST['firstDegreeFamily'];
    $relative = $_POST['relative'];
    $diagnosis = $_POST['diagnosis'];
    $takenF2F = $_POST['takenF2F'];
    $whyF2FTeacher = $_POST['whyF2FTeacher'];
    $coTeach = $_POST['coTeach'];
    $coTeachWith = $_POST['coTeachWith'];
    $knowWhere = $_POST['knowWhere'];
    $teachWhere = $_POST['teachWhere'];

    if ($convict == 'no') {
        $convictText = 'N/A';
    }

    if ($coTeach == 'no') {
        $coTeachWith = 'N/A';
    }

    if ($knowWhere == 'no') {
        $teachWhere = 'N/A';
    }

    //add data to hive
    $f3->set('convict', $convict);
    $f3->set('convictText', $convictText);
    $f3->set('firstDegreeFamily', $firstDegreeFamily);
    $f3->set('relative', $relative);
    $f3->set('diagnosis', $diagnosis);
    $f3->set('takenF2F', $takenF2F);
    $f3->set('whyF2FTeacher', $whyF2FTeacher);
    $f3->set('coTeach', $coTeach);
    $f3->set('coTeachWith', $coTeachWith);
    $f3->set('knowWhere', $knowWhere);
    $f3->set('teachWhere', $teachWhere);

    $_SESSION['LongAnswer'] =  new F2FLongAnswers($convict, $convictText, $firstDegreeFamily, $relative, $diagnosis, $takenF2F,
                                $whyF2FTeacher, $coTeach, $coTeachWith, $knowWhere, $teachWhere);

    if(validF2FLongAnswersForm())
    {
        if($_POST['goToReview'] == true)
        {
            $f3->reroute('/review');
        }

        $f3->reroute('/not_required');
    }
}

if(!isset($_SESSION['LongAnswer']))
{
    $_SESSION['LongAnswer'] = new F2FLongAnswers('', '', '', '', '', '',
                                                '', '', '', '', '');
}


