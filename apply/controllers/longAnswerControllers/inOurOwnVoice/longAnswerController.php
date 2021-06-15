<?php
global $f3;

if(!empty($_POST))
{
    // get data from form
    $convict = $_POST['convict'];
    $convictText = $_POST['convictText'];
    $degree = $_POST['degree'];
    $volunteerExperience =  $_POST['volunteerExperience'] ;
    $diagnose = $_POST['diagnose'];
    $diagnoseTime = $_POST['diagnoseTime'];
    $currentDiagnosis = $_POST['currentDiagnosis'];
    $hospitalized = $_POST['hospitalized'];
    $recently = $_POST['recently'];
    $speakingExperience = $_POST['speaking'];
    $comfortable = $_POST['comfortable'];
    $transportation = $_POST['transportation'];
    $notWantPresent = $_POST['notWantPresent'];
    $whyPresenter = $_POST['whyPresenter'];
    $stayedRecover = $_POST['stayedRecover'];
    $recovery = $_POST['recovery'];

    if($convict == 'no')
    {
        $convictText = 'N/A';
    }
    if($hospitalized == 'no')
    {
        $recently = 'N/A';
    }


    //add data to hive
    $f3->set('convict',$convict);
    $f3->set('convictText',$convictText);
    $f3->set('degree', $degree);
    $f3->set('volunteerExperience',$volunteerExperience) ;
    $f3->set('diagnose',$diagnose);
    $f3->set('diagnoseTime',$diagnoseTime);
    $f3->set('currentDiagnosis',$currentDiagnosis);
    $f3->set('hospitalized',$hospitalized);
    $f3->set('recently', $recently);
    $f3->set('speaking', $speakingExperience);
    $f3->set('comfortable',$comfortable);
    $f3->set('transportation', $transportation);
    $f3->set('notWantPresent', $notWantPresent);
    $f3->set('whyPresenter',$whyPresenter);
    $f3->set('stayedRecover', $stayedRecover);
    $f3->set('recovery',$recovery);

    $_SESSION['LongAnswer'] =  new IOOVLongAnswers($convict, $convictText, $degree, $volunteerExperience, $diagnose, $diagnoseTime,
        $currentDiagnosis, $hospitalized, $recently, $speakingExperience, $comfortable, $transportation,
        $notWantPresent, $whyPresenter, $stayedRecover, $recovery);


    if(validIOOVLongAnswersForm())
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
    $_SESSION['LongAnswer'] = new IOOVLongAnswers('','','','','','',
        '','','','','','',
        '','','','');
}
