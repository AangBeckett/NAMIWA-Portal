<?php
global $f3;

if(!empty($_POST))
{
    // get data from form
    $convict = $_POST['convict'];
    $convictText = $_POST['convictText'];
    $availability = $_POST['availability'];
    $degree = $_POST['degree'];
    $volunteerExperience = $_POST['volunteerExperience'];
    $fluentLanguage = $_POST['fluentLanguage'];
    $youngAdult = $_POST['youngAdult'];
    $describes = $_POST['describes'];
    $currentDiagnosis = $_POST['currentDiagnosis'];
    $disclosure = $_POST['disclosure'];
    $outlook = $_POST['outlook'];
    $background = $_POST['background'];
    $presenterText = $_POST['presenterText'];
    $frontLineExperienceText = $_POST['frontLineExperienceText'];
    $supportiveExperienceText = $_POST['supportiveExperienceText'];
    $recoveryText = $_POST['recoveryText'];

    if ($convict == 'no')
    {
        $convictText = 'N/A';
    }

    if (isset($_POST['availability'])) {
        $availability = "<pre>" .implode("\n", $_POST['availability'])."</pre>";
    }

    if (isset($_POST['describes'])) {
        $describes = "<pre>" .implode(", \n", $_POST['describes'])."</pre>";
    }

    //add data to hive
    $f3->set('convict', $convict);
    $f3->set('convictText', $convictText);
    $f3->set('availability', $availability);
    $f3->set('degree', $degree);
    $f3->set('volunteerExperience', $volunteerExperience);
    $f3->set('fluentLanguage', $fluentLanguage);
    $f3->set('youngAdult', $youngAdult);
    $f3->set('describes', $describes);
    $f3->set('currentDiagnosis', $currentDiagnosis);
    $f3->set('disclosure', $disclosure);
    $f3->set('outlook', $outlook);
    $f3->set('background', $background);
    $f3->set('presenterText', $presenterText);
    $f3->set('frontLineExperienceText', $frontLineExperienceText);
    $f3->set('supportiveExperienceText', $supportiveExperienceText);
    $f3->set('recoveryText', $recoveryText);

    $_SESSION['LongAnswer'] =  new PELongAnswers($convict, $convictText, $availability, $degree, $volunteerExperience,
         $fluentLanguage, $youngAdult, $describes, $currentDiagnosis, $disclosure, $outlook, $background, $presenterText,
        $frontLineExperienceText, $supportiveExperienceText, $recoveryText);

    if(validPELongAnswersForm())
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
    $_SESSION['LongAnswer'] = new PELongAnswers( '', '', '', '', '',
    '', '', '', '', '', '', '', '',
    '', '', '');
}
