<?php
/**
 * Controller for portal routes
 *
 * @author Jason Engelbrecht
 * @author Olivia Ringhiser
 * @author Imelda Medina
 * @author Maureen Kariuki
 *
 * Date: 6/14/2020
 */
global $f3;
global $db;

//login
$f3->route('GET|POST /login', function ($f3) {
    $f3->set('page_title', 'Login');
    global $db;

    //for logout/just in case
    $_SESSION['loggedIn'] = 0;

    if (!empty($_POST)) {

        //get email and password
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        //get user password with email
        $adminUser = $db->getAdminPassword($email);

        //sticky email
        $_SESSION['adminEmail'] = $email;

        //verify correct password entered
        if (password_verify($password, $adminUser['password'])) {

            //set logged in to 1 - and set name
            $_SESSION['loggedIn'] = 1;
            $_SESSION['adminFname'] = $adminUser['fname'];
            $_SESSION['adminLname'] = $adminUser['lname'];

            //get rid of
            unset($_SESSION['adminEmail']);

            //go to dashboard
            $f3->reroute('/dashboard');
        } else {
            $f3->set('loginError', 'Email and password do not match');
        }
    }

    $view = new Template();
    echo $view->render('views/portal/account/login.html');
});

//forgot password
$f3->route('GET|POST /forgot-password', function ($f3) {
    global $db;
    $f3->set('page_title', 'Forgot Password');

    if (!empty($_POST)) {
        Emailer::sendResetEmail($_POST['email'], $db);
    }

    $view = new Template();
    echo $view->render('views/portal/account/forgot-password.html');
});

//reset password
$f3->route('GET|POST /reset-password/@adminId/@hashcode', function ($f3, $params) {
    $f3->set('page_title', 'Reset Password');

    global $db;
    $hashedId = str_replace('-', '/', $params['hashcode']);
    if (!password_verify($params['adminId'], $hashedId)) {
        $f3->reroute('/login');
    }

    if (!empty($_POST)) {
        $db->changeAdminPassword($params['adminId'], $_POST['password']);
        $f3->reroute('/login');
    }

    $view = new Template();
    echo $view->render('views/portal/account/reset-password.html');
});

//create account
$f3->route('GET|POST /create-account', function ($f3) {
    $f3->set('page_title', 'Create Account');
    global $db;

    /*if($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }*/

    //form submission
    if (!empty($_POST)) {
        //get post data
        $fname = $_POST['adminFname'];
        $lname = $_POST['adminLname'];
        $email = $_POST['adminEmail'];
        $password = $_POST['adminPassword'];
        $passwordRepeat = $_POST['adminPasswordRepeat'];

        $f3->set('adminFname', $fname);
        $f3->set('adminLname', $lname);
        $f3->set('adminEmail', $email);

        //validate
        if (validAccount($fname, $lname, $email, $password, $passwordRepeat)) {
            //prefill email for login
            $_SESSION['adminEmail'] = $email;

            //insert into db - go to login
            $db->insertAdminUser($fname, $lname, $email, $password);
            $f3->reroute('/login');
        }
    }

    $view = new Template();
    echo $view->render('views/portal/account/register.html');
});

//dashboard
$f3->route('GET|POST /dashboard', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    //get metrics
    global $db;
    $active = 1;

    $numActive = $db->countApplicants($active);
    $numComplete = $db->countComplete();
    $numApproved = $db->countApproved();
    $numDenied = $db->countDenied();
    $numWaitlisted = $db->countApplicants(2);
    $numArchived = $db->countApplicants(0);
    $numSubmitted = $db->countSubmitted();
    $numTrainings = $db->countTrainings();
    $numDate = $db->countDate();
    $numApplicationByMonthYear = $db->countApplicationByMonthYear();
    $first = $db->getTheFirstSlacker();
    $second = $db->getTheSecondSlacker();
    $third = $db->getTheThirdSlacker();
    $fourth = $db->getTheFourthSlacker();
    $fifth = $db->getTheFifthSlacker();
    $firstPercentage = $db->getTheFirstPercentage();
    $secondPercentage = $db->getTheSecondPercentage();
    $thirdPercentage = $db->getTheThirdPercentage();
    $fourthPercentage = $db->getTheFourthPercentage();
    $fifthPercentage = $db->getTheFifthPercentage();

    $f3->set('numActive', $numActive);
    $f3->set('numComplete', $numComplete);
    $f3->set('numApproved', $numApproved);
    $f3->set('numDenied', $numDenied);
    $f3->set('numWaitlisted', $numWaitlisted);
    $f3->set('numArchived', $numArchived);
    $f3->set('numSubmitted', $numSubmitted);
    $f3->set('numTrainings', $numTrainings);
    $f3->set('numDate', $numDate);
    $f3->set('numApplicationByMonthYear', $numApplicationByMonthYear);
    $f3->set('first', $first);
    $f3->set('second', $second);
    $f3->set('third', $third);
    $f3->set('fourth', $fourth);
    $f3->set('fifth', $fifth);
    $f3->set('firstPercentage', $firstPercentage);
    $f3->set('secondPercentage', $secondPercentage);
    $f3->set('thirdPercentage', $thirdPercentage);
    $f3->set('fourthPercentage', $fourthPercentage);
    $f3->set('fifthPercentage', $fifthPercentage);

    $labelDataForGraph = array();
    $barDataForGraph = array();

    for ($i = 0; $i < sizeof($numDate); $i++) {
        array_push($labelDataForGraph, $numDate[$i]['MonthYear']);
        array_push($barDataForGraph, $numApplicationByMonthYear[$i]['AppSubmit']);

    }

    $f3->set('labelDataForGraph', json_encode($labelDataForGraph));
    $f3->set('barDataForGraph', json_encode($barDataForGraph));

    $f3->set('page', 'dashboard');
    $f3->set('page_title', 'Dashboard');

    //set up excel export
    $app_types = $db->getAppTypes();
    $f3->set('app_types', $app_types);

    if (!empty($_POST)) {
        Exporter::exportTrainingInfo($_POST['formType'], $db);
    }

    $view = new Template();
    echo $view->render('views/portal/dashboard.html');
});

//active
$f3->route('GET|POST /active', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    global $db;
    $f3->set('page', 'active');
    $f3->set('page_title', 'Active Applicants');

    //get all active applicants
    $active = 1;
    $f3->set('ActiveApplicants', $db->getApplicants($active));

    //get various metrics
    $f3->set('active', $db->countApplicants($active));
    $f3->set('submitted', $db->countSubmitted());
    $f3->set('approved', $db->countApproved());
    $f3->set('denied', $db->countDenied());
    $f3->set('complete', $db->countComplete());
    $f3->set('numDate', $db->countDate());
    $f3->set('numApp', $db->countApplicationByMonthYear());

    //update submission
    if (isset($_POST['update'])) {

        $id = $_POST['id'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];

        //run update query
        $db->updateApplicant($id, $category, $status, $notes);
        $f3->reroute('/active');
    }

    if (isset($_POST['resendEmail'])) {
        $id = $_POST['id'];
        $db->updateApplicantStatus(1, $id);
        $personal = $db->getInfoForEmailResend($id);
        Emailer::sendAffiliateEmail($id, $personal['fname'], $personal['lname'], $personal['affiliate'], $db);
        $f3->set('emailSent', true);
        $f3->set('affiliateName', $db->getAffiliateName($personal['affiliate']));
    }

    $view = new Template();
    echo $view->render('views/portal/applications/active.html');
});

//waitlist
$f3->route('GET|POST /waitlist', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    //get all waitlisted applicants
    global $db;
    $waitilist = 2;
    $f3->set('WaitlistedApplicants', $db->getApplicants($waitilist));
    $f3->set('numWaitlist', $db->countApplicants($waitilist));

    $f3->set('page', 'waitlist');
    $f3->set('page_title', 'Waitlisted Applicants');

    //update submission
    if (isset($_POST['updateWaitlist'])) {

        $id = $_POST['id'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];

        //run update query
        $db->updateApplicant($id, $category, $status, $notes);
        $f3->reroute('/waitlist');
    }

    $view = new Template();
    echo $view->render('views/portal/applications/waitlist.html');
});

//archive
$f3->route('GET|POST /archive', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    //get all archived applicants
    global $db;
    $archive = 0;
    $f3->set('ArchivedApplicants', $db->getApplicants($archive));
    $f3->set('numArchive', $db->countApplicants($archive));

    $f3->set('page', 'archive');
    $f3->set('page_title', 'Archived Applicants');

    //update submission
    if (isset($_POST['updateArchive'])) {

        $id = $_POST['id'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];

        //run update query
        $db->updateApplicant($id, $category, $status, $notes);
        $f3->reroute('/archive');
    }

    $view = new Template();
    echo $view->render('views/portal/applications/archive.html');
});

//affiliates
$f3->route('GET /affiliates', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    $f3->set('page', 'affiliates');
    $f3->set('page_title', 'Affiliates');


    //get all affiliates
    global $db;
    $f3->set('Affiliates', $db->getAffiliates());
    $f3->set('NumAffiliates', $db->countAffiliates());

    //update submission
    if (isset($_POST['updateAffiliate'])) {

        $id = $_POST['id'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $notes = $_POST['notes'];

        //run update query
        $db->updateApplicant($id, $category, $status, $notes);
        $f3->reroute('/affiliates');
    }
    $view = new Template();
    echo $view->render('views/portal/other/affiliates.html');
});

//trainings
$f3->route('GET|POST /trainings', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    $f3->set('page', 'trainings');
    $f3->set('page_title', 'Trainings');

    //get trainings
    global $db;
    $f3->set('db', $db);
    $f3->set('trainings', $db->getAppTypes());
    $f3->set('trainings_infos', $db->getAppTypesInfo());

    //get locations
    global $db;
    $f3->set('locations', $db->getLocations());

    //delete a location
    if (isset($_POST['deleteLocation'])) {
        $location_id = $_POST['deleteLocationId'];
        $db->deleteLocation($location_id);
        $db->updateLocation($location_id);
        $f3->reroute('/trainings');
    }

    //add training
    if (isset($_POST['add'])) {
        //insert
        $date = $_POST['dates'];
        $date2 = $_POST['dates2'];
        $date3 = $_POST['dates3'];
        $location = $_POST['location'];
        $deadline = $_POST['deadline'];
        $id = $_POST['addId'];
        //validate
        if (validTrainingDate($date) && validTrainingDates($date, $date2, $date3) && validDeadline($date, $deadline)) {
            $db->insertAppTypeInfo($id, $date, $date2, $date3, $location, $deadline);
            $f3->reroute('/trainings');
        }
    }

    //delete training
    if (isset($_POST['delete'])) {
        $id = $_POST['deleteId'];
        $db->deleteAppTypeInfo($id);
        $f3->reroute('/trainings');
    }

    //add a location
    if (isset($_POST['addNewLocation'])) {
        $location = $_POST['addTrainingLocation'];

        if (validLocation($location)) {
            $db->addANewLocation($location);
            $f3->reroute('/trainings');
        }
    }

    //edit training
    if (isset($_POST['edit'])) {
        $date = $_POST['editDates'];
        if (isset($_POST['editDates2'])) {
            $date2 = $_POST['editDates2'];
        } else {
            $date2 = null;
        }
        if (isset($_POST['editDates3'])) {
            $date3 = $_POST['editDates3'];
        } else {
            $date3 = null;
        }
        $location = $_POST['editLocation'];
        $deadline = $_POST['editDeadline'];
        $id = $_POST['editId'];

        //validate
        if (validTrainingDate($date) && validTrainingDates($date, $date2, $date3) && validDeadline($date, $deadline)) {
            $db->editAppTypeInfo($id, $date, $date2, $date3, $location, $deadline);
            $f3->reroute('/trainings');
        }
    }

    $view = new Template();
    echo $view->render('views/portal/other/trainings.html');
});

$f3->route('GET /oldTrainings', function ($f3) {
    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    $f3->set('page', 'trainings');
    $f3->set('page_title', 'Old Trainings');

    //get all affiliates
    global $db;
    $f3->set('oldTrainings', $db->getOldAppTypesInfo());

    $view = new Template();
    echo $view->render('views/portal/other/oldTrainings.html');
});


//full application
$f3->route('GET /@applicant', function ($f3, $params) {

    if ($_SESSION['loggedIn'] !== 1) {
        $f3->reroute('/login');
    }

    $f3->set('page_title', 'Applicant');

    global $db;

    $applicant_id = $params['applicant']; //must match^
    $applicant = $db->getApplicant($applicant_id);

    $otherArr = $db->getOtherID($applicant_id);
    $otherID = $otherArr['other_affiliate_id'];

    if ($otherID != null) {
        $other = $db->getOtherAffiliate($otherID);
        $f3->set('other', $other);
    }

    //get app type
    $app_type = $applicant['app_type'];

    //pull data based on app type and id
    $longAnswers = $db->getLongAnswer($applicant_id, $app_type);
    $routing = $applicant['Reference'];

    //set to hive
    $f3->set('longAnswers', $longAnswers);

    $f3->set('applicant', $applicant);
    $f3->set('reviewIncludes', "views/portal/applications/long_answers/$routing/long_answer.html");

    if ($applicant['category'] == 1) {
        $f3->set('page', 'active');
    } else if ($applicant['category'] == 0) {
        $f3->set('page', 'archive');
    } else if ($applicant['category'] == 2) {
        $f3->set('page', 'waitlist');
    }

    $view = new Template();
    echo $view->render('views/portal/applications/applicant.html');
});

//edit application questions
$f3->route('GET /app_questions', function ($f3) {
    $f3->set('page_title', 'Edit Question Navigation');
    global $db;
    $f3->set('trainings', $db->getAppTypes());
    $app = $_GET['trainingType'];

    if (isset($_POST[$app])) {
        $f3->reroute("/question_edit?type=$app");
    }

    $view = new Template();
    echo $view->render('views/portal/other/editQuestionsNav.html');
});


$f3->route("GET|POST /question_edit", function ($f3) {
    $app = $_GET['type'];
    $type = '';
    $f3->set('page_title', 'Edit Questions');
    global $db;
    switch ($app) {
        case
        'basics':
            $questions = $db->getBQs();
            $keys = array_keys($questions);
            $f3->set('bQuestions', $questions);
            $f3->set('bKeys', $keys);
            $type = 'B';
            break;
        case 'homefront':
            $questions = $db->getHQs();
            $keys = array_keys($questions);
            $f3->set('hQuestions', $questions);
            $f3->set('hKeys', $keys);
            $type = 'H';
            break;
        case 'familySupportGroup':
            $questions = $db->getFSGQs();
            $keys = array_keys($questions);
            $f3->set('fsgQuestions', $questions);
            $f3->set('fsgKeys', $keys);
            $type = 'FSG';
            break;
        case 'peer2peer':
            $questions = $db->getP2PQs();
            $keys = array_keys($questions);
            $f3->set('p2pQuestions', $questions);
            $f3->set('p2pKeys', $keys);
            $type = 'P2P';
            break;
        case 'endingTheSilence':
            $questions = $db->getETSQs();
            $keys = array_keys($questions);
            $f3->set('etsQuestions', $questions);
            $f3->set('etsKeys', $keys);
            $type = 'ETS';
            break;
        case 'providerEducation':
            $questions = $db->getPEQs();
            $keys = array_keys($questions);
            $f3->set('peQuestions', $questions);
            $f3->set('peKeys', $keys);
            $type = 'PE';
            break;
        case 'family2family':
            $questions = $db->getF2FQs();
            $keys = array_keys($questions);
            $f3->set('f2fQuestions', $questions);
            $f3->set('f2fKeys', $keys);
            $type = 'F2F';
            break;
        case 'inOurOwnVoice':
            $questions = $db->getIOOVQs();
            $keys = array_keys($questions);
            $f3->set('ioovQuestions', $questions);
            $f3->set('ioovKeys', $keys);
            $type = 'IOOV';
            break;
        case 'connection':
            $questions = $db->getCQs();
            $keys = array_keys($questions);
            $f3->set('cQuestions', $questions);
            $f3->set('cKeys', $keys);
            $type = 'C';
            break;
    }
    if (isset($_POST['editQs'])) {
        $question = $_POST['questionId'];
        $newText = $_POST['newText'];
        $db->updateQs($type, $question, $newText);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    $view = new Template();
    echo $view->render("views/portal/other/edit_questions/$app/editAppQuestions.html");
});