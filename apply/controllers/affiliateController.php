<?php
/**
 * Controller for affiliate routes
 *
 * @author Jason Engelbrecht, Max Lee,Imelda Medina, & Olivia Ringhiser
 * Date: 06/14/2020
 */
global $f3;
global $db;

$f3->route('GET|POST /affiliate_review/@applicantId/@hashcode', function ($f3, $params) {
    $hashedId = str_replace('-', '/', $params['hashcode']);
    if (!password_verify($params['applicantId'], $hashedId)) {
        $f3->reroute('/home');
    }

    $f3->set('page_title', 'Application Approve/Deny');

    global $db;

    if (!empty($_POST)) {
        $db->insertAffiliateNotes($params['applicantId'], $_POST['affiliateNotes'], $_POST['membershipExpiration']);

        if ($_POST['saveNotes'] != 'save') {
            $db->updateApplicantStatus($_POST['newStatus'], $params['applicantId']);

            //reroute to thank you message
            $f3->reroute('/affiliate_confirmation');
        }
    }

    $applicant = $db->getApplicant($params['applicantId']);

    //if app is already denied, no need to show it
    if ($applicant['app_status'] == 0) {
        $f3->reroute('/application_reviewed');
    }

    //get app id
    $app_id = $params['applicantId'];


    //"other" affiliate info
    $otherArr = $db->getOtherID($app_id);
    $otherID = $otherArr['other_affiliate_id'];

    if ($otherID != null) {
        $other = $db->getOtherAffiliate($otherID);
        $f3->set('other', $other);
    }

    //get app type
    $app_type = $applicant['app_type'];

    //pull data based on app type and id
    $longAnswers = $db->getLongAnswer($app_id, $app_type);
    $refName = $db->getRefName($app_type);
    $routing = $refName['ref_name'];

    //set to hive
    $f3->set('longAnswers', $longAnswers);

    $f3->set('applicant', $applicant);
    $f3->set('affiliate', $db->getAffiliateName($applicant['affiliate']));
    $f3->set('reviewIncludes', "views/affiliate/long_answers/$routing/affiliateReviewIncludes.html");

    $view = new Template();
    echo $view->render('views/affiliate/affiliateReview.html');
});

$f3->route('GET|POST /affiliates/affiliate_to_dos/@applicantId', function ($f3, $params) {
    global $db;
    $f3->set('page_title', 'Affiliate To Dos');
    if (!empty($_POST)) {
        $db->updateApprovalInfo($params['applicantId'], $_POST['membershipExpiration'], $_POST['leaderName'],
            $_POST['leaderTitle'], $_POST['affiliateType'], date("m/d/Y"), $_POST['checkNumber']);

        //re-route to confirmation page
        $f3->reroute('/to_do_confirmation');
    }
    $view = new Template();
    echo $view->render('views/affiliate/affiliateToDos.html');
});

$f3->route('GET /affiliates/affiliateToDos.pdf', function ($f3) {
    $f3->set('page_title', 'Affiliate To Dos');
    $view = new Template();
    echo $view->render('views/affiliate/affiliateToDos.pdf');
});

$f3->route('GET|POST /to_do_confirmation', function ($f3) {
    $f3->set('page_title', 'Thank you!');

    $view = new Template();
    echo $view->render('views/affiliate/toDoConfirmation.html');
});

$f3->route('GET|POST /affiliate_confirmation', function ($f3) {
    $f3->set('page_title', 'Thank you!');

    $view = new Template();
    echo $view->render('views/affiliate/thankyouConfirmation.html');
});

$f3->route('GET /application_reviewed', function ($f3) {
    $f3->set('page_title', 'Already reviewed');

    $view = new Template();
    echo $view->render('views/affiliate/alreadyReviewed.html');
});

//affiliates
$f3->route('GET|POST /affiliates', function ($f3) {

    //get all affiliates
    global $db;
    $f3->set('Affiliates', $db->getAffiliates());

    //delete affiliate
    if (isset($_POST['deleteAffiliate'])) {
        $affiliateId = $_POST['deleteId'];

        $db->deleteAffiliate($affiliateId);
        $f3->reroute('/affiliates');
    }

    //update affiliate

    if (isset($_POST['updateAffiliate'])) {
        $name = $_POST['editAffiliate'];
        $email = $_POST['editAffiliateEmail'];
        $affiliateId = $_POST['id'];
        $db->updateAffiliate($name, $email, $affiliateId);
        $f3->reroute('/affiliates');
    }


    //add affiliate

    if (isset($_POST['addAffiliateSave'])) {
        $name = $_POST['addAffiliate'];
        $email = $_POST['addEmail'];
        $db->addAffiliate($name, $email);
        $f3->reroute('/affiliates');
    }

    $view = new Template();
    echo $view->render('views/portal/other/affiliates.html');
});