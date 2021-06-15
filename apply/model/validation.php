<?php
/**
 * Validation file for user input
 * @author Max Lee
 * @author Imelda Medina
 * @author Olivia Ringhiser
 * @copyright 10/27/2019
 */

/**
 * used to validate the personal info form
 * @return bool if everything was valid or not
 */
function validPersonalInfoForm()
{
    global $f3;
    $isValid = true;

    if (!alphabetical($f3->get('fname'))) {
        $isValid = false;
        $f3->set("errors['fname']", "Please enter a valid first name");
    }

    if (!alphabetical($f3->get('lname'))) {
        $isValid = false;
        $f3->set("errors['lname']", "Please enter a valid last name");
    }

    if (!alphabetical($f3->get('pronouns'))) {
        $isValid = false;
        $f3->set("errors['pronouns']", "Please enter a valid pronoun");
    }

    if (!validDOB($f3->get('dateOfBirth'))) {
        $isValid = false;
        $f3->set("errors['dateOfBirth']", "Please enter your date of birth in the format MM/DD/YYY");
    }

    if (!alphabetical($f3->get('member'))) {
        $isValid = false;
        $f3->set("errors['member']", "Please enter a valid member selection");
    }

    if (empty($f3->get('affiliate')) || $f3->get('affiliate') == 'none') {
        $isValid = false;
        $f3->set("errors['affiliate']", "Please enter a valid affiliate");
    }

    if (empty($f3->get('address'))) {
        $isValid = false;
        $f3->set("errors['address']", "Please enter a valid street address");
    }

    if (!alphabetical($f3->get('city'))) {
        $isValid = false;
        $f3->set("errors['city']", "Please enter a valid city");
    }

    if (empty($f3->get('state')) || $f3->get('state') == 'none') {
        $isValid = false;
        $f3->set("errors['state']", "Please enter a valid state");
    }

    if (!validZip($f3->get('zip'), $f3->get('state'))) {
        $isValid = false;
        $f3->set("errors['zip']", "Please enter a valid zip");
    }

    if (!numeric($f3->get('primary_phone'))) {
        $isValid = false;
        $f3->set("errors['primary_phone']", "Please enter a valid primary phone number");
    }

    if ((!numeric($f3->get('alternate_phone')) && ($f3->get('alternate_phone') != ' '))) {
        $isValid = false;
        $f3->set("errors['primary_phone']", "Please enter a valid alternate phone number");
    }

    if (empty($f3->get('primary_time'))) {
        $isValid = false;
        $f3->set("errors['primary_time']", "Please enter a primary time to call");
    }

    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email address");
    }

    if ($f3->get('preference') != 'phone' && $f3->get('preference') != 'email' && $f3->get('preference') != 'both') {
        $isValid = false;
        $f3->set("errors['preference']", "Please choose a best way to contact you");
    }

    if (!alphabetical($f3->get('emergency_name'))) {
        $isValid = false;
        $f3->set("errors['emergency_name']", "Please enter a valid emergency contact");
    }

    if (!numeric($f3->get('emergency_phone'))) {
        $isValid = false;
        $f3->set("errors['emergency_phone']", "Please enter a valid emergency contact phone number");
    }

    return $isValid;
}

/**
 * used to validate the accommodations form
 * @return bool if everything was valid or not
 */
function validAccommodationsForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('needAccommodations') == 'true') {
        if ($f3->get('singleRoom') == 'true') {
            if (!alphabetical($f3->get('gender'))) {
                $isValid = false;
                $f3->set("errors['gender']", "Please enter a gender");
            }

            if (!alphabetical($f3->get('roommateGender'))) {
                $isValid = false;
                $f3->set("errors['roommateGender']", "Please enter a gender for your roommate");
            }

            if (!validDaysRooming($f3->get('daysRooming'))) {
                $isValid = false;
                $f3->set("errors['daysRooming']", "Please select at least 1 day to room");
            }
        }
    }

    return $isValid;
}

/** Checks if the long answer form is valid
 * @return bool if the long answers is valid
 */
function validFSGLongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('relativeMentalIllness') == 'yes') {
        if (!validRequiredTextarea($f3->get('relativeMentalIllnessText'))) {
            $isValid = false;
            $f3->set("errors['relativeMentalIllness']", "Please type something about your relative");
        }
    }

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }

    if (!validRequiredTextarea($f3->get('whyFacilitator'))) {
        $isValid = false;
        $f3->set("errors['whyFacilitator']", "Please type something about why you want to become a facilitator");
    }

    if (!validRequiredTextarea($f3->get('experience'))) {
        $isValid = false;
        $f3->set("errors['experience']", "Please type something about your experiences in support groups");
    }

    if ($f3->get('coFacWhom') == 'yes') {
        if (!validRequiredTextarea($f3->get('coFacWhomText'))) {
            $isValid = false;
            $f3->set("errors['coFacWhom']", "Please type something who you want to co-facilitate with");
        }
    }

    if ($f3->get('coFacWhere') == 'yes') {
        if (!validRequiredTextarea($f3->get('coFacWhereText'))) {
            $isValid = false;
            $f3->set("errors['coFacWhere']", "Please type something about where you want to co-facilitate");
        }
    }

    return $isValid;
}

/**
 * Checks if P2P long answers are valid
 * @return bool whether or not the P2P long answers form is valid
 */
function validP2PLongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }

    if (!validRequiredTextarea($f3->get('whyLeader'))) {
        $isValid = false;
        $f3->set("errors['whyLeader']", "Please type something about why you want to become a Peer to Peer leader");
    }

    if (!validRequiredTextarea($f3->get('mentalHealth'))) {
        $isValid = false;
        $f3->set("errors['mentalHealth']", "Please type something about how you define or describe mental health recovery");
    }

    if (!validRequiredTextarea($f3->get('giveBack'))) {
        $isValid = false;
        $f3->set("errors['giveBack']", "Please type something why you feel you are ready to “give back” to others");
    }

    return $isValid;
}

/**
 * Checks if ETS long answers are valid
 * @return bool whether or not the ETS long answers form is valid
 */
function validETSLongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }

    if (empty($f3->get('availability'))) {
        $isValid = false;
        $f3->set("errors['availability']", "Please type something about your availability");
    }

    if (!validRequiredTextarea($f3->get('education'))) {
        $isValid = false;
        $f3->set("errors['education']", "Please type something about your education");
    }

    if (!validRequiredTextarea($f3->get('experience'))) {
        $isValid = false;
        $f3->set("errors['experience']", "Please type something about your work/volunteer experience");
    }

    if (!validRequiredTextarea($f3->get('languages'))) {
        $isValid = false;
        $f3->set("errors['languages']", "Please type something about the languages you know");
    }

    if (!validRequiredTextarea($f3->get('diagnosis'))) {
        $isValid = false;
        $f3->set("errors['diagnosis']", "Please type something ");
    }

    if (!validRequiredTextarea($f3->get('whyPresenter'))) {
        $isValid = false;
        $f3->set("errors['whyPresenter']", "Please type something about why you want to become a presenter");
    }

    if (!validRequiredTextarea($f3->get('personalExperience'))) {
        $isValid = false;
        $f3->set("errors['personalExperience']", "Please type something about your personal experience");
    }

    if (!validRequiredTextarea($f3->get('supportiveExperience'))) {
        $isValid = false;
        $f3->set("errors['supportiveExperience']", "Please type something about a supportive experience");
    }

    if (!validRequiredTextarea($f3->get('recoveryMeaning'))) {
        $isValid = false;
        $f3->set("errors['recoveryMeaning']", "Please type something about what mental recovery means to you");
    }

    if (!validRequiredTextarea($f3->get('roles'))) {
        $isValid = false;
        $f3->set("errors['roles']", "Please type something about your view on roles");
    }

    return $isValid;
}

/**
 * Checks if F2F long answers are valid
 * @return bool whether or not the F2F long answers form is valid
 */
function validF2FLongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }

    if (!validRequiredTextarea($f3->get('relative'))) {
        $isValid = false;
        $f3->set("errors['relative']", "Please type which family member ");
    }

    if (!validRequiredTextarea($f3->get('diagnosis'))) {
        $isValid = false;
        $f3->set("errors['diagnosis']", "Please type something ");
    }

    if (!validRequiredTextarea('whyF2FTeacher')) {
        $isValid = false;
        $f3->set("errors['whyF2FTeacher']", "Please tell us why you would like to be a Family-To-Family teacher");
    }

    if ($f3->get('coTeach') == 'yes') {
        if (!validRequiredTextarea($f3->get('coTeachWith'))) {
            $isValid = false;
            $f3->set("errors['coTeachWith']", "Please tell us who you would like to coteach with");
        }
    }
    if ($f3->get('knowWhere') == 'yes') {
        if (!validRequiredTextarea($f3->get('teachWhere'))) {
            $isValid = false;
            $f3->set("errors['teachWhere']", "Please tell us where you would like to teach");
        }
    }
    return $isValid;
}

/**
 * Checks if B long answers are valid
 * @return bool whether or not the B long answers form is valid
 */
function validBLongAnswersForm()
{
    global $f3;
    $isValid = true;
    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }
    if ($f3->get('parent') == 'yes') {
        if (!numeric($f3->get('childAge'))) {
            $isValid = false;
            $f3->set("errors['childAge']", "Please enter a valid child age");
        }
        if ($f3->get('givenDiagnosis') == 'yes') {
            if (!validRequiredTextarea($f3->get('currentDiagnosis'))) {
                $isValid = false;
                $f3->set("errors['currentDiagnosis']", "Please tell us your child's diagnosis");
            }
            if (!validRequiredTextarea($f3->get('lengthOfIllness'))) {
                $isValid = false;
                $f3->set("errors['lengthOfIllness']", "Please tell us how long your child has been showing symptoms");
            }
        }
    }
    if ($f3->get('publicSchool') == 'no') {
        if (!validRequiredTextarea($f3->get('educationalProgram'))) {
            $isValid = false;
            $f3->set("errors['publicSchool']", "Please tell us about your child's educational program");
        }
    }
    if ($f3->get('highSchoolGrad') == 'yes') {
        if (!validRequiredTextarea($f3->get('gradDate'))) {
            $isValid = false;
            $f3->set("errors['highSchoolGrad']", "Please list your child's graduation date");
        }
    }
    if (!validRequiredTextarea('whyBasicsTeacher')) {
        $isValid = false;
        $f3->set("errors['whyBasicsTeacher']", "Please tell us why you would like to be a Basics teacher");
    }
    if (!validRequiredTextarea('childExperiences')) {
        $isValid = false;
        $f3->set("errors['childExperiences']", "Please tell us about your experiences living with a child with mental illness");
    }
    if ($f3->get('coteach') == 'yes') {
        if (!validRequiredTextarea($f3->get('coteachWith'))) {
            $isValid = false;
            $f3->set("errors['coteachWith']", "Please tell us who you would like to coteach with");
        }
    }
    if ($f3->get('knowWhere') == 'yes') {
        if (!validRequiredTextarea($f3->get('teachWhere'))) {
            $isValid = false;
            $f3->set("errors['teachWhere']", "Please tell us where you would like to teach");
        }
    }
    return $isValid;
}

/**
 * Checks if IOOV long answers are valid
 * @return bool whether or not the IOOV long answers form is valid
 */
function validIOOVLongAnswersForm()
{
    global $f3;
    $isValid = true;
    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }
    if (!validRequiredTextarea($f3->get('degree'))) {
        $isValid = false;
        $f3->set("errors['degree']", "Please type your last degree");
    }
    if (!validRequiredTextarea($f3->get('volunteerExperience'))) {
        $isValid = false;
        $f3->set("errors['volunteerExperience']", "Please type your volunteer experience");
    }
    if (!validRequiredTextarea($f3->get('diagnose'))) {
        $isValid = false;
        $f3->set("errors['diagnose']", "Please type were you first diagnosed");
    }
    if (!validRequiredTextarea($f3->get('diagnoseTime'))) {
        $isValid = false;
        $f3->set("errors['diagnoseTime']", "Please type how old were you when diagnosed");
    }
    if (!validRequiredTextarea($f3->get('currentDiagnosis'))) {
        $isValid = false;
        $f3->set("errors['currentDiagnosis']", "Please type your current diagnosis");
    }
    if ($f3->get('hospitalized') == 'yes') {
        if (!validRequiredTextarea($f3->get('recently'))) {
            $isValid = false;
            $f3->set("errors['hospitalized']", "Please type how recently");
        }
    }

    if (!validRequiredTextarea($f3->get('notWantPresent'))) {
        $isValid = false;
        $f3->set("errors['notWantPresent']", "Please type which groups you do not want to present");
    }
    if (!validRequiredTextarea($f3->get('whyPresenter'))) {
        $isValid = false;
        $f3->set("errors['whyPresenter']", "Please type why do you want to be a Presenter");
    }
    if (!validRequiredTextarea($f3->get('stayedRecover'))) {
        $isValid = false;
        $f3->set("errors['stayedRecover']", "Please share a personal statement");
    }
    if (!validRequiredTextarea($f3->get('recovery'))) {
        $isValid = false;
        $f3->set("errors['recovery']", "Please share your views about medicine");
    }

    return $isValid;
}

/**
 * Checks if C long answers are valid
 * @return bool whether or not the C long answers form is valid
 */
function validCLongAnswersForm()
{
    global $f3;
    $isValid = true;
    if (!validRequiredTextarea($f3->get('whyFacilitator'))) {
        $isValid = false;
        $f3->set("errors['whyFacilitator']", "Please type why do you want to be a facilitator");
    }
    if (!validRequiredTextarea($f3->get('experience'))) {
        $isValid = false;
        $f3->set("errors['experience']", "Please type your experience");
    }
    if (!validRequiredTextarea($f3->get('description'))) {
        $isValid = false;
        $f3->set("errors['description']", "Please type your definition");
    }
    return $isValid;
}

/**
 * Checks if H long answers are valid
 * @return bool whether or not the H long answers form is valid
 */
function validHLongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }
    if (!validRequiredTextarea($f3->get('relationship'))) {
        $isValid = false;
        $f3->set("errors['relationship']", "Please tell us your relationship to your veteran");
    }
    if ($f3->get('diagnosis') == 'yes') {
        if (!validRequiredTextarea($f3->get('diagnosis'))) {
            $isValid = false;
            $f3->set("errors['diagnosis']", "Please tell us about your veteran's diagnosis");
        }
    }
    if (!validRequiredTextarea($f3->get('whyHomefrontTeacher'))) {
        $isValid = false;
        $f3->set("errors['whyHomefrontTeacher']", "Please tell us about why you would like to be a Homefront teacher");
    }
    if ($f3->get('coteach') == 'yes') {
        if (!validRequiredTextarea($f3->get('coteachWith'))) {
            $isValid = false;
            $f3->set("errors['coteachWith']", "Please tell us who you would like to coteach with");
        }
    }
    if ($f3->get('knowWhere') == 'yes') {
        if (!validRequiredTextarea($f3->get('teachWhere'))) {
            $isValid = false;
            $f3->set("errors['teachWhere']", "Please tell us where you would like to teach");
        }
    }
    return $isValid;
}


/**
 * Checks if PE long answers are valid
 * @return bool whether or not the PE long answers form is valid
 */
function validPELongAnswersForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('convict') == 'yes') {
        if (!validRequiredTextarea($f3->get('convictText'))) {
            $isValid = false;
            $f3->set("errors['convict']", "Please type something about your conviction");
        }
    }


    if (empty($f3->get('availability'))) {
        $isValid = false;
        $f3->set("errors['availability']", "Please select your availability");
    }

    if (!validRequiredTextarea($f3->get('degree'))) {
        $isValid = false;
        $f3->set("errors['degree']", "Please type something about your education");
    }

    if (!validRequiredTextarea($f3->get('volunteerExperience'))) {
        $isValid = false;
        $f3->set("errors['volunteerExperience']", "Please type something about your work/volunteer experience");
    }

    if (!validRequiredTextarea($f3->get('fluentLanguage'))) {
        $isValid = false;
        $f3->set("errors['fluentLanguage']", "Please type something about the languages you know");
    }

    if (empty($f3->get('describes'))) {
        $isValid = false;
        $f3->set("errors['describes']", "Please select all that describes you");
    }

    if (!validRequiredTextarea($f3->get('currentDiagnosis'))) {
        $isValid = false;
        $f3->set("errors['currentDiagnosis']", "Please type something ");
    }

    if (!validRequiredTextarea($f3->get('presenterText'))) {
        $isValid = false;
        $f3->set("errors['presenterText']", "Please type something about why you want to become a presenter");
    }

    if (!validRequiredTextarea($f3->get('frontLineExperienceText'))) {
        $isValid = false;
        $f3->set("errors['frontLineExperienceText']", "Please type something about your personal experience");
    }

    if (!validRequiredTextarea($f3->get('supportiveExperienceText'))) {
        $isValid = false;
        $f3->set("errors['supportiveExperienceText']", "Please type something about a supportive experience");
    }

    if (!validRequiredTextarea($f3->get('recoveryText'))) {
        $isValid = false;
        $f3->set("errors['recoveryText']", "Please type something about what mental recovery means to you");
    }

    return $isValid;
}

/**
 * Checks if S long answers are valid
 * @return bool whether or not the S long answers form is valid
 */
function validSLongAnswersForm()
{
    global $f3;
    $isValid = true;
    return $isValid;
}

/** Checks if the not required form is valid
 * @return bool if the not required form is valid
 */
function validNotRequiredForm()
{
    global $f3;
    $isValid = true;

    if ($f3->get('trained') == 'yes') {
        if (!validRequiredTextarea($f3->get('trainedText'))) {
            $isValid = false;
            $f3->set("errors['trained']", "Please type about your training");
        }
    }

    if ($f3->get('certified') == 'yes') {
        if (!validRequiredTextarea($f3->get('certifiedText'))) {
            $isValid = false;
            $f3->set("errors['certified']", "Please type about your certifications");
        }
    }

    return $isValid;
}

/** Checks if the Date of Birth is valid
 * @param $dob String Date of Birth
 * @return bool if its valid
 */
function validDOB($dob)
{
    $nums = explode("/", $dob);
    foreach ($nums as $datePiece) {
        if (!numeric($datePiece)) {
            return false;
        }
    }
    //check month is valid
    if ($nums[0] < 1 || $nums[0] > 12) {
        return false;
    }

    //check if days are valid
    if ($nums[1] < 1 || $nums[1] > 31) {
        return false;
    }

    //check if year is valid
    if ($nums[2] < 1920 || $nums[2] > 2020) {
        return false;
    }
    return true;
}

/**
 * Checks if the days rooming given was valid
 * @param array the days the applicant is staying
 * @return bool if the name was valid
 */
function validDaysRooming($days)
{
    return $days[0] != 'N/A';
}

/** Checks if the applicant wrote something
 * @param $textarea String if something is written
 * @return bool if the textarea
 */
function validRequiredTextarea($textarea)
{
    return !empty($textarea) && $textarea != "";
}

/**
 * Checks if the String given was valid
 * @param String $value the value given
 * @return bool if the name was valid
 */
function alphabetical($value)
{
    return !empty($value) && ctype_alpha(str_replace(array(' ', "'", '-', '.', '/', ','), '', $value));
}

/**
 * Checks if the number given was valid
 * @param String $value the value given
 * @return bool if the name was valid
 */
function numeric($value)
{
    return !empty($value) && ctype_digit(str_replace(array('-', '(', ')', ' '), '', $value));
}

/**
 * Checks if the email is valid
 * @param String $email the email given
 * @return bool if the email was valid ot not
 */
function validEmail($email)
{
    //global $db;
    //$emailValid = $db->checkEmail($email);
    /**
     * if (empty($emailValid))
     * {
     * }
     * return false;
     * */

    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Checks if zip code is in valid US zip or Canadian postal code format
 * @param String $zip the provided zip code
 * @return bool if the zip is valid or not
 */
function validZip($zip, $state)
{
    $canada = array('Alberta', 'British Columbia', 'Manitoba', 'New Brunswick',
        'Newfoundland and Labrador', 'Nova Scotia', 'Ontario',
        'Prince Edward Island', 'Quebec', 'Saskatchewan', 'Northwest Territories',
        'Nunavut', 'Yukon');
    //Matches Canadian postal pattern with or without space
    //taken from https://regexlib.com/REDetails.aspx?regexp_id=1293, added @ anchor tags
    if (in_array($state, $canada)) {
        return preg_match('@([ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ])\ ?([0-9][ABCEGHJKLMNPRSTVWXYZ][0-9])@', $zip);
    }
    //Matches US 5 digit and 5 + 4 digit zip codes
    return preg_match('@^\d{5}(-\d{4})?$@', $zip);
}

//////////////////admin portal validation////////////////////////////
/**
 * Check if admin create account input is all valid
 *
 * @param $fname
 * @param $lname
 * @param $email
 * @param $password
 * @param $passwordRepeat
 * @return bool
 */
function validAccount($fname, $lname, $email, $password, $passwordRepeat)
{

    $isValid = true;

    if (!validAdminName($fname)) {
        $isValid = false;
    }

    if (!validAdminName($lname)) {
        $isValid = false;
    }

    if (!validAdminEmail($email)) {
        $isValid = false;
    }

    if (!validPassword($password, $passwordRepeat)) {
        $isValid = false;
    }

    return $isValid;
}

/**
 * Check for valid admin password
 *
 * @param $password
 * @param $passwordRepeat
 * @return bool
 */
function validPassword($password, $passwordRepeat)
{
    global $f3;

    //regexes
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);

    //make sure password has uppercase, lowercase, number and is between 8 and 20 character
    if (!$uppercase || !$lowercase || !$number || (strlen($password) < 8 && strlen($password) > 20)) {
        $f3->set("adminErrors['passwordSpec']", "Please enter a password following the recommendations");
        return false;
    }

    //if password is good, check for matching
    if (!($password === $passwordRepeat)) {
        $f3->set("adminErrors['passwordMatch']", "Your passwords do not match");
        return false;
    }

    return true;
}

/**
 * Check for valid admin email
 *
 * @param $email
 * @return bool
 */
function validAdminEmail($email)
{
    global $f3;
    global $db;

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $f3->set("adminErrors['email']", "Please enter a valid email");
        return false;
    }

    //check if email is already in use
    if ($db->getAdminEmail($email) != false) {
        $f3->set("adminErrors['email']", "This email is already in use");
        return false;
    }

    return true;
}

/**
 * Check for valid admin name
 *
 * @param $name
 * @return bool
 */
function validAdminName($name)
{
    global $f3;

    if (!alphabetical($name)) {
        $f3->set("adminErrors['name']", "Please enter a valid name");
        return false;
    }

    return true;
}

/**
 * Check for valid admin name
 *
 * @param $name
 * @param $email
 * @return bool
 */
function validAffiliate($name, $email)
{
    global $f3;

    if (!alphabetical($name)) {
        $f3->set("affiliateErrors['name']", "Please enter a valid name");
        return false;
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $f3->set("affiliateErrors['email']", "Please enter a valid email");
        return false;
    }
    return true;
}

/**
 * Checks that the training date is a real date and not in the past
 *
 * @param $date
 * @return bool
 */
function validTrainingDate($date)
{
    global $f3;

    if (!checkdate(date("m", strtotime($date)), date("d", strtotime($date)), date("Y", strtotime($date)))) {
        $f3->set("errors['date']", "Please enter a valid date");
        return false;
    } else if ($date < date('Y-m-d')) {
        $f3->set("errors['date']", "Please enter a date set in the future");
        return false;
    } else if ($date == date('Y-m-d')) {
        $f3->set("errors['date']", "Entered date is today");
        return false;
    }
    return true;
}

/**
 * Ensures that if there are multiple training days, they are
 * consecutive and in the correct order
 *
 * @param $date
 * @param $date2
 * @param $date3
 * @return bool
 */
function validTrainingDates($date, $date2 = null, $date3 = null)
{
    global $f3;
    $expectedDay2 = date('Y-m-d', strtotime("$date +1 day"));
    $expectedDay3 = date('Y-m-d', strtotime("$date2 +1 day"));
    if ($date2) {
        if ($date2 < $date) {
            $f3->set("errors['date2']", "Day 2 occurs before Day 1");
            return false;
        } elseif ($date2 != $expectedDay2) {
            $f3->set("errors['date2']", "Day 2 is not consecutive with Day 1");
            return false;
        }
        if ($date3) {
            if ($date3 < $date2) {
                $f3->set("errors['date3']", "Day 3 occurs before Day 2");
                return false;
            } elseif ($date3 != $expectedDay3) {
                $f3->set("errors['date3']", "Day 3 is not consecutive with Day 2");
                return false;
            }
        }
    }
    return true;
}

/**
 * Ensures that the deadline occurs before the training date
 *
 * @param $date
 * @param $deadline
 * @return bool
 */
function validDeadline($date, $deadline)
{
    global $f3;
    if ($deadline >= $date) {
        $f3->set("errors['deadline']", "The deadline occurs after the training date");
        return false;
    }
    return true;
}

/**
 * @param $location
 * @return bool
 */
function validLocation($location)
{
    global $f3;
    if (!alphabetical($location) && empty(trim($location))) {
        $f3->set("locationErrors['location']", "Please enter a valid location");
        return false;
    }
    return true;
}