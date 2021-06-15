<?php
global $f3;

if (!empty($_POST)) {
    // get data from form
    $convict = $_POST['convict'];
    $convictText = $_POST['convictText'];
    $takenBasics = $_POST['takenBasics'];
    $takenF2F = $_POST['takenF2F'];
    $parent = $_POST['parent'];
    $childAge = $_POST['childAge'];
    $givenDiagnosis = $_POST['givenDiagnosis'];
    $currentDiagnosis = $_POST['currentDiagnosis'];
    $lengthOfIllness = $_POST['lengthOfIllness'];
    $publicSchool = $_POST['publicSchool'];
    $educationalProgram = $_POST['educationalProgram'];
    $highSchoolGrad = $_POST['highSchoolGrad'];
    $gradDate = $_POST['gradDate'];
    $whyBasicsTeacher = $_POST['whyBasicsTeacher'];
    $childExperiences = $_POST['childExperiences'];
    $coteach = $_POST['coteach'];
    $coteachWith = $_POST['coteachWith'];
    $knowWhere = $_POST['knowWhere'];
    $teachWhere = $_POST['teachWhere'];


    if ($convict == 'no') {
        $convictText = 'N/A';
    }

    if ($parent == 'no') {
        $childAge = 'N/A';
        $givenDiagnosis = 'N/A';
        $currentDiagnosis = 'N/A';
        $lengthOfIllness = 'N/A';
    }

    if ($givenDiagnosis == 'no') {
        $currentDiagnosis = 'Not yet officially diagnosed';
    }

    if ($publicSchool == 'yes') {
        $educationalProgram = 'Public school';
    }

    if ($highSchoolGrad == 'no') {
        $gradDate = 'Not graduated yet';
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
    $f3->set('takenBasics', $takenBasics);
    $f3->set('takenF2F', $takenF2F);
    $f3->set('parent', $parent);
    $f3->set('childAge', $childAge);
    $f3->set('givenDiagnosis', $givenDiagnosis);
    $f3->set('currentDiagnosis', $currentDiagnosis);
    $f3->set('lengthOfIllness', $lengthOfIllness);
    $f3->set('publicSchool', $publicSchool);
    $f3->set('educationalProgram', $educationalProgram);
    $f3->set('highSchoolGrad', $highSchoolGrad);
    $f3->set('gradDate', $gradDate);
    $f3->set('whyBasicsTeacher', $whyBasicsTeacher);
    $f3->set('childExperiences', $childExperiences);
    $f3->set('coteach', $coteach);
    $f3->set('coteachWith', $coteachWith);
    $f3->set('knowWhere', $knowWhere);
    $f3->set('teachWhere', $teachWhere);

    $_SESSION['LongAnswer'] = new BLongAnswers($convict, $convictText, $takenBasics, $takenF2F, $parent, $childAge,
        $givenDiagnosis, $currentDiagnosis, $lengthOfIllness, $publicSchool, $educationalProgram, $highSchoolGrad,
        $gradDate, $whyBasicsTeacher, $childExperiences, $coteach, $coteachWith, $knowWhere, $teachWhere);

    if (validBLongAnswersForm()) {
        if ($_POST['goToReview'] == true) {
            $f3->reroute('/review');
        }

        $f3->reroute('/not_required');
    }
}

if (!isset($_SESSION['LongAnswer'])) {
    $_SESSION['LongAnswer'] = new BLongAnswers('', '', '', '', '', '',
        '', '', '', '', '', '',
        '', '', '', '', '', '', '');
}
