<?php /** @noinspection SqlResolve */


/**
 * Class Database
 * SQL setup statements in model
 *
 * @author Max Lee
 * @author Jason Engelbrecht
 * @author Olivia Ringhiser
 * @author Imelda Medina
 * @author Maureen Kariuki
 * Date: 6/14/2020
 */
class UnamiDatabase
{
    private $_dbh;

    /**
     * Database constructor. connects to the database when made
     * @return void
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Connects to the database
     * @return void
     */
    function connect()
    {
        try {
            // Instantiate a db object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'connected';
        } catch (PDOException $e) {
            //echo $e->getMessage();
        }
    }

    ////////////////////////////////////////////////////FORMS///////////////////////////////////////////////////////////

    /**
     * @param $personalInfo PersonalInfo
     * @param $accommodations AdditionalInfo
     * @param $notRequired NotRequired
     * @param $info_id
     * @return int the id of the last applicant
     */
    function addApplicant($personalInfo, $accommodations, $notRequired, $info_id)
    {
        //prepare SQL statement
        $sql = "INSERT INTO applicants(date_submitted, app_status, category, app_type, fname, pname, lname, pronouns, birthdate, NAMI_member, 
                affiliate, address, city, address2, state, zip, primary_phone, primary_time, alternate_phone, 
                alternate_time, email, preference, emergency_name, emergency_phone, special_needs, service_animal, 
                mobility_need, need_rooming, single_room, days_rooming, gender, roommate_gender, cpap_user, 
                roommate_cpap, heard_about_training, other_classes, certified, info_id, affiliate_type, approver_name,
                approver_title, approval_date, check_number) 
                VALUES (NOW(), :app_status, :category, :app_type, :fname, :pname, :lname, :pronouns, :birthdate, :NAMI_member, 
                :affiliate, :address, :city, :address2, :state, :zip, :primary_phone, :primary_time, 
                :alternate_phone, :alternate_time, :email, :preference, :emergency_name, :emergency_phone, 
                :special_needs, :service_animal, :mobility_need, :need_rooming, :single_room, :days_rooming, 
                :gender, :roommate_gender, :cpap_user, :roommate_cpap, :heard_about_training, :other_classes, 
                :certified, :info_id, :affiliate_type, :approver_name, :approver_title, :approval_date, :check_number)";

        // save prepared statement
        $statement = $this->_dbh->prepare($sql);

        // assign values
        $status = 1;
        $category = 1;
        $app_type = 1;

        //personal info
        $fname = $personalInfo->getFname();
        $pname = $personalInfo->getPname();
        $lname = $personalInfo->getLname();
        $pronouns = $personalInfo->getPronouns();
        $birthdate = $personalInfo->getDobMonth() . '/' . $personalInfo->getDobDay() . '/' . $personalInfo->getDobYear();
        if ($personalInfo->getMember() == 'yes') {
            $NAMI_member = true;
        } else {
            $NAMI_member = false;
        }

        //Have to change to use foreign key: it does
        $NAMI_affiliate = $personalInfo->getAffiliate();
        $address = $personalInfo->getAddress();
        $city = $personalInfo->getCity();
        $address2 = $personalInfo->getAddress2();
        $state = $personalInfo->getState();
        $zip = $personalInfo->getZip();
        $primary_phone = $personalInfo->getPrimaryPhone();
        $primary_time = $personalInfo->getPrimaryTime();
        $alternate_phone = $personalInfo->getAlternatePhone();
        $alternate_time = $personalInfo->getAlternateTime();
        $email = $personalInfo->getEmail();
        $preference = $personalInfo->getPreference();
        $emergency_name = $personalInfo->getEmergencyName();
        $emergency_phone = $personalInfo->getEmergencyPhone();

        //accommodations
        $special_needs = ($accommodations->getSpecialNeedsText());
        $service_animal = ($accommodations->getServiceAnimalText());
        $mobility_need = ($accommodations->getMovementDisabilityText());
        $need_rooming = ($accommodations->getNeedAccommodations() == 'true' ? "Yes" : "No");
        $single_room = ($accommodations->getSingleRoom() == 'true' ? "Yes" : "No");

        $daysAsString = '';
        if (is_array($accommodations->getDaysRooming())) {
            foreach ($accommodations->getDaysRooming() as $day) {
                $daysAsString .= $day;
                $daysAsString .= ' ';
            }
        } else {
            $daysAsString = "Not needed";
        }

        $days_rooming = $daysAsString;
        $gender = $accommodations->getGender();
        $roommate_gender = $accommodations->getRoommateGender();
        $cpap_user = ($accommodations->getCpap() == 'true' ? "Yes" : "No");
        $roommateCpap = ($accommodations->getCpapRoommate() == 'true' ? "Yes" : "No");

        //not required
        $heard_about_training = $notRequired->getHeardAboutTraining();
        $other_classes = 'Not trained in any other classes';
        if ($notRequired->getTrained() == 'yes') {
            $other_classes = $notRequired->getTrainedText();
        }
        $certified = 'Not certified to train any other classes';
        if ($notRequired->getCertified() == 'yes') {
            $certified = $notRequired->getCertifiedText();
        }

        // bind params
        $statement->bindParam(':app_status', $status, PDO::PARAM_INT);
        $statement->bindParam(':category', $category, PDO::PARAM_INT);
        $statement->bindParam(':app_type', $app_type, PDO::PARAM_INT);

        //personal info
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':pname', $pname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':pronouns', $pronouns, PDO::PARAM_STR);
        $statement->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam(':NAMI_member', $NAMI_member, PDO::PARAM_BOOL);
        $statement->bindParam(':affiliate', $NAMI_affiliate, PDO::PARAM_STR);
        $statement->bindParam(':address', $address, PDO::PARAM_STR);
        $statement->bindParam(':city', $city, PDO::PARAM_STR);
        $statement->bindParam(':address2', $address2, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':zip', $zip, PDO::PARAM_STR);
        $statement->bindParam(':primary_phone', $primary_phone, PDO::PARAM_STR);
        $statement->bindParam(':primary_time', $primary_time, PDO::PARAM_STR);
        $statement->bindParam(':alternate_phone', $alternate_phone, PDO::PARAM_STR);
        $statement->bindParam(':alternate_time', $alternate_time, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':preference', $preference, PDO::PARAM_STR);
        $statement->bindParam(':emergency_name', $emergency_name, PDO::PARAM_STR);
        $statement->bindParam(':emergency_phone', $emergency_phone, PDO::PARAM_STR);

        //accommodations
        $statement->bindParam(':special_needs', $special_needs, PDO::PARAM_STR);
        $statement->bindParam(':service_animal', $service_animal, PDO::PARAM_STR);
        $statement->bindParam(':mobility_need', $mobility_need, PDO::PARAM_STR);
        $statement->bindParam(':need_rooming', $need_rooming, PDO::PARAM_STR);
        $statement->bindParam(':single_room', $single_room, PDO::PARAM_STR);
        $statement->bindParam(':days_rooming', $days_rooming, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':roommate_gender', $roommate_gender, PDO::PARAM_STR);
        $statement->bindParam(':cpap_user', $cpap_user, PDO::PARAM_STR);
        $statement->bindParam(':roommate_cpap', $roommateCpap, PDO::PARAM_STR);

        //not required
        $statement->bindParam(':heard_about_training', $heard_about_training, PDO::PARAM_STR);
        $statement->bindParam(':other_classes', $other_classes, PDO::PARAM_STR);
        $statement->bindParam(':certified', $certified, PDO::PARAM_STR);

        //training info id
        $statement->bindParam(':info_id', $info_id, PDO::PARAM_STR);


        //awaiting approval
        $wait = 'awaiting approval';
        $statement->bindParam(':affiliate_type', $wait, PDO::PARAM_STR);
        $statement->bindParam(':approver_name', $wait, PDO::PARAM_STR);
        $statement->bindParam(':approver_title', $wait, PDO::PARAM_STR);
        $statement->bindParam(':approval_date', $wait, PDO::PARAM_STR);
        $statement->bindParam(':check_number', $wait, PDO::PARAM_STR);

        // execute insert into users
        $statement->execute();

        return $this->_dbh->lastInsertId();
    }

    function otherAffiliateInfo($otherAffiliate)
    {
        $sql = "INSERT INTO other_affiliate(affiliate_name, leader_name, leader_email, leader_phone)
        VALUES (:affiliate_name, :leader, :email, :phone)";

        $statement = $this->_dbh->prepare($sql);

        $name = $otherAffiliate->getAffiliateName();
        $leader = $otherAffiliate->getLeaderName();
        $email = $otherAffiliate->getLeaderEmail();
        $phone = $otherAffiliate->getLeaderPhone();

        $statement->bindParam(':affiliate_name', $name, PDO::PARAM_STR);
        $statement->bindParam(':leader', $leader, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

        $statement->execute();
        return $this->_dbh->lastInsertId();
    }

    /**
     * Links "other" affiliate information to a specified applicant
     * @param $otherID non-WA affiliate id
     * @param $applicantID applicant id
     */
    function insertOtherAffiliate($otherID, $applicantID)
    {
        $sql = "UPDATE applicants SET other_affiliate_id = :other_id WHERE applicant_id = :applicant_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':other_id', $otherID, PDO::PARAM_INT);
        $statement->bindParam(':applicant_id', $applicantID, PDO::PARAM_INT);

        $statement->execute();
    }

    function getOtherId($applicantID)
    {
        $sql = "SELECT other_affiliate_id from applicants WHERE applicant_id = :applicant_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':applicant_id', $applicantID, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get information of non-Washington State affiliate
     * @param $otherID id of the other affiliate
     * @return mixed affiliate info
     */
    function getOtherAffiliate($otherID)
    {
        $sql = "SELECT affiliate_name, leader_name, leader_email, leader_phone FROM other_affiliate
        WHERE affiliate_id = :other_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':other_id', $otherID, PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id int applicant's id
     * @return mixed Info needed to resend email to affiliate
     */
    function getInfoForEmailResend($id)
    {
        $sql = "SELECT fname, lname, affiliate FROM applicants WHERE applicant_id = :app_id";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':app_id', $id, PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $appType int
     * @param $applicantId int
     */
    function updateAppType($appType, $applicantId)
    {
        $sql = "UPDATE applicants SET app_type = :app_type WHERE applicant_id = :applicant_id";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':app_type', $appType, PDO::PARAM_INT);
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Inserts answers to FamilySupportGroup questions
     * @param $applicantId int id of last inserted
     * @param $FSGAnswers FSGLongAnswers object that holds all data
     */
    function insertFSGAnswers($applicantId, $FSGAnswers)
    {
        $this->updateAppType(1, $applicantId);
        //prepare SQL statement
        $sql = "INSERT INTO FSG(applicant_id, relative_mental, conviction, why_want, experience, whom_co, where_co) 
                VALUES (:applicant_id, :relative_mental, :conviction, :why_want, :experience, :whom_co, :where_co)";

        //save prepared statement
        $statement = $this->_dbh->prepare($sql);

        //assign values: already in $FSGAnswers
        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':relative_mental', $FSGAnswers->getRelativeMentalIllness(), PDO::PARAM_STR);
        $statement->bindParam(':conviction', $FSGAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $FSGAnswers->getWhyFacilitator(), PDO::PARAM_STR);
        $statement->bindParam(':experience', $FSGAnswers->getExperience(), PDO::PARAM_STR);
        $statement->bindParam(':whom_co', $FSGAnswers->getCoFacWhomText(), PDO::PARAM_STR);
        $statement->bindParam(':where_co', $FSGAnswers->getCoFacWhereText(), PDO::PARAM_STR);

        //execute SQL statement
        $statement->execute();
    }

    /**
     * Inserts the answers to P2P's long answer questions
     * @param $applicantId int last applicant inserted
     * @param $P2PAnswers P2PLongAnswers holds all P2P long answers
     */
    function insertP2PAnswers($applicantId, $P2PAnswers)
    {
        $this->updateAppType(2, $applicantId);
        //prepare SQL statement
        $sql = "INSERT INTO P2P(applicant_id, conviction, why_want, describe_recovery, give_back) 
                VALUES (:applicant_id, :conviction, :why_want, :describe_recovery, :give_back)";

        //save prepared statement
        $statement = $this->_dbh->prepare($sql);

        //assign values: already in $P2PAnswers
        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $P2PAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $P2PAnswers->getWhyLeader(), PDO::PARAM_STR);
        $statement->bindParam(':describe_recovery', $P2PAnswers->getMentalHealth(), PDO::PARAM_STR);
        $statement->bindParam(':give_back', $P2PAnswers->getGiveBack(), PDO::PARAM_STR);

        //execute SQL statement
        $statement->execute();
    }

    /**
     * Inserts the ETS long answer's into the DB
     * @param $applicantId int last applicant inserted
     * @param $ETSAnswers ETSLongAnswers holds all answers
     */
    function insertETSAnswers($applicantId, $ETSAnswers)
    {
        $this->updateAppType(3, $applicantId);
        //prepare SQL statement
        $sql = "INSERT INTO ETS(applicant_id, conviction, availability, education, experience, languages, age, 
                diagnosis, self_disclosure, positive_outlook, background_check, why_want, 
                mental_experience, support_experience, recovery, view_roles) 
                VALUES (:applicant_id, :conviction, :availability, :education, :experience, :languages, :age, 
                :diagnosis, :self_disclosure, :positive_outlook, :background_check, :why_want, 
                :mental_experience, :support_experience, :recovery, :view_roles)";

        //save prepared statement
        $statement = $this->_dbh->prepare($sql);

        //assign values: already in $ETSAnswers
        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $ETSAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':availability', $ETSAnswers->getAvailability(), PDO::PARAM_STR);
        $statement->bindParam(':education', $ETSAnswers->getEducation(), PDO::PARAM_STR);
        $statement->bindParam(':experience', $ETSAnswers->getExperience(), PDO::PARAM_STR);
        $statement->bindParam(':languages', $ETSAnswers->getLanguages(), PDO::PARAM_STR);
        $statement->bindParam(':age', $ETSAnswers->getYoungAdult(), PDO::PARAM_STR);
        //$statement->bindParam(':description', $ETSAnswers->get(), PDO::PARAM_STR);
        $statement->bindParam(':diagnosis', $ETSAnswers->getDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':self_disclosure', $ETSAnswers->getSelfDisclosure(), PDO::PARAM_STR);
        $statement->bindParam(':positive_outlook', $ETSAnswers->getPositiveOutlook(), PDO::PARAM_STR);
        $statement->bindParam(':background_check', $ETSAnswers->getBackgroundCheck(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $ETSAnswers->getWhyPresenter(), PDO::PARAM_STR);
        $statement->bindParam(':mental_experience', $ETSAnswers->getPersonalExperience(), PDO::PARAM_STR);
        $statement->bindParam(':support_experience', $ETSAnswers->getSupportiveExperience(), PDO::PARAM_STR);
        $statement->bindParam(':recovery', $ETSAnswers->getRecoveryMeaning(), PDO::PARAM_STR);
        $statement->bindParam(':view_roles', $ETSAnswers->getRoles(), PDO::PARAM_STR);

        //execute SQL statement
        $statement->execute();
    }

    /**
     * Inserts the C long answer's into the DB
     * @param $applicantId int last applicant inserted
     * @param $CAnswers CLongAnswers holds all answers
     */
    function insertCAnswers($applicantId, $CAnswers)
    {
        $this->updateAppType(4, $applicantId);
        $sql = "INSERT INTO C(applicant_id, why_facilitator, experience, description)
            VALUES (:applicant_id, :why_facilitator, :experience, :description)";

        //save prepared statement
        $statement = $this->_dbh->prepare($sql);

        //assign values: already in $CAnswers
        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':why_facilitator', $CAnswers->getWhyFacilitator(), PDO::PARAM_STR);
        $statement->bindParam(':experience', $CAnswers->getExperience(), PDO::PARAM_STR);
        $statement->bindParam(':description', $CAnswers->getDescription(), PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Inserts the IOOV long answer's into the DB
     * @param $applicantId int last applicant inserted
     * @param $IOOVAnswers IOOVLongAnswers holds all answers
     */
    function insertIOOVAnswers($applicantId, $IOOVAnswers)
    {
        $this->updateAppType(5, $applicantId);
        $sql = "INSERT INTO IOOV(applicant_id, conviction, degree, volunteer_exp, diagnose, diagnose_time, current_diagnosis,
            hospitalized, speaking_exp, comfortable, transportation, not_present, why_presenter, time_recovered, recovery)
            VALUES(:applicant_id, :conviction, :degree, :volunteer_exp, :diagnose, :diagnose_time, :current_diagnosis,
            :hospitalized, :speaking_exp, :comfortable, :transportation, :not_present, :why_presenter, :time_recovered, :recovery)";
        //save prepared statement
        $statement = $this->_dbh->prepare($sql);

        //assign values: already in $IIOVAnswers
        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $IOOVAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':degree', $IOOVAnswers->getDegree(), PDO::PARAM_STR);
        $statement->bindParam(':volunteer_exp', $IOOVAnswers->getVolunteerExperience(), PDO::PARAM_STR);
        $statement->bindParam(':diagnose', $IOOVAnswers->getDiagnose(), PDO::PARAM_STR);
        $statement->bindParam(':diagnose_time', $IOOVAnswers->getDiagnoseTime(), PDO::PARAM_STR);
        $statement->bindParam(':current_diagnosis', $IOOVAnswers->getCurrentDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':hospitalized', $IOOVAnswers->getRecently(), PDO::PARAM_STR);
        $statement->bindParam(':speaking_exp', $IOOVAnswers->getSpeakingExperience(), PDO::PARAM_STR);
        $statement->bindParam(':comfortable', $IOOVAnswers->getComfortable(), PDO::PARAM_INT);
        $statement->bindParam(':transportation', $IOOVAnswers->getTransportation(), PDO::PARAM_STR);
        $statement->bindParam(':not_present', $IOOVAnswers->getNotWantPresent(), PDO::PARAM_STR);
        $statement->bindParam(':why_presenter', $IOOVAnswers->getWhyPresenter(), PDO::PARAM_STR);
        $statement->bindParam(':time_recovered', $IOOVAnswers->getStayedRecover(), PDO::PARAM_STR);
        $statement->bindParam(':recovery', $IOOVAnswers->getRecovery(), PDO::PARAM_STR);
        $statement->execute();
    }


    /**
     * @param $applicantId
     * @param $PEAnswers
     */
    function insertPEAnswers($applicantId, $PEAnswers)
    {
        $this->updateAppType(6, $applicantId);
        $sql = "INSERT INTO PE (applicant_id, conviction, availability, degree, volunteer_exp, 
                fluent_language, young_adult, describes, current_diagnosis, self_disclosure, positive_outlook, 
                background_check, why_want, frontLine_experience, support_experience, recovery)
                VALUES (:applicant_id, :conviction, :availability, :degree, :volunteer_exp, 
                :fluent_language, :young_adult, :describes, :current_diagnosis, :self_disclosure, :positive_outlook, 
                :background_check, :why_want, :frontLine_experience, :support_experience, :recovery)";
        $statement = $this->_dbh->prepare($sql);

        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $PEAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':availability', $PEAnswers->getAvailability(), PDO::PARAM_STR);
        $statement->bindParam(':degree', $PEAnswers->getDegree(), PDO::PARAM_STR);
        $statement->bindParam(':volunteer_exp', $PEAnswers->getVolunteerExperience(), PDO::PARAM_STR);
        $statement->bindParam(':fluent_language', $PEAnswers->getFluentLanguage(), PDO::PARAM_STR);
        $statement->bindParam(':young_adult', $PEAnswers->getYoungAdult(), PDO::PARAM_STR);
        $statement->bindParam(':describes', $PEAnswers->getDescribes(), PDO::PARAM_STR);
        $statement->bindParam(':current_diagnosis', $PEAnswers->getCurrentDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':self_disclosure', $PEAnswers->getDisclosure(), PDO::PARAM_STR);
        $statement->bindParam(':positive_outlook', $PEAnswers->getOutlook(), PDO::PARAM_STR);
        $statement->bindParam(':background_check', $PEAnswers->getBackground(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $PEAnswers->getPresenterText(), PDO::PARAM_STR);
        $statement->bindParam(':frontLine_experience', $PEAnswers->getFrontLineExperienceText(), PDO::PARAM_STR);
        $statement->bindParam(':support_experience', $PEAnswers->getSupportiveExperienceText(), PDO::PARAM_STR);
        $statement->bindParam(':recovery', $PEAnswers->getRecoveryText(), PDO::PARAM_STR);

        //execute SQL statement
        $statement->execute();
    }

    /**
     * @param $applicantId
     * @param $F2FAnswers
     */
    function insertF2FAnswers($applicantId, $F2FAnswers)
    {
        $this->updateAppType(7, $applicantId);

        //define query
        $sql = "INSERT INTO F2F(applicant_id, conviction, first_degree_family, your_relative, diagnosis, taken_f2f, 
                why_want, coteach_with, teach_where) VALUES(:applicant_id, :conviction, :first_degree_family, 
                :your_relative, :diagnosis, :taken_f2f, :why_want, :coteach_with, :teach_where)";

        //prepare statement
        $statement = $this->_dbh->prepare($sql);

        //bind params
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $F2FAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':first_degree_family', $F2FAnswers->getFirstDegreeFamily(), PDO::PARAM_STR);
        $statement->bindParam(':your_relative', $F2FAnswers->getRelative(), PDO::PARAM_STR);
        $statement->bindParam(':diagnosis', $F2FAnswers->getDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':taken_f2f', $F2FAnswers->getTakenF2F(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $F2FAnswers->getWhyF2FTeacher(), PDO::PARAM_STR);
        $statement->bindParam(':coteach_with', $F2FAnswers->getCoTeachWith(), PDO::PARAM_STR);
        $statement->bindParam(':teach_where', $F2FAnswers->getTeachWhere(), PDO::PARAM_STR);

        //execute statement
        $statement->execute();

    }

    function insertHAnswers($applicantId, $HAnswers)
    {
        $this->updateAppType(8, $applicantId);
        $sql = "INSERT INTO H(applicant_id,	conviction,	relationship, diagnosis, taken_f2f,	why_want, coteach_with,
              teach_where) VALUES(:applicant_id, :conviction, :relationship, :diagnosis, :taken_f2f, :why_want, 
                                  :coteach_with, :teach_where)";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $HAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':relationship', $HAnswers->getRelationship(), PDO::PARAM_STR);
        $statement->bindParam(':diagnosis', $HAnswers->getDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':taken_f2f', $HAnswers->getTakenF2F(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $HAnswers->getWhyHomefrontTeacher(), PDO::PARAM_STR);
        $statement->bindParam(':coteach_with', $HAnswers->getCoteachWith(), PDO::PARAM_STR);
        $statement->bindParam(':teach_where', $HAnswers->getTeachWhere(), PDO::PARAM_STR);
        $statement->execute();
    }

    function insertBAnswers($applicantId, $BAnswers)
    {
        $this->updateAppType(9, $applicantId);
        $sql = "INSERT INTO B(applicant_id,	conviction,	taken_basics, taken_f2f, parent, child_age,
              current_diagnosis, length_of_illness, educational_program, grad_date,	why_want,
              child_experiences, coteach_with, teach_where) VALUES (:applicant_id,	:conviction, :taken_basics, :taken_f2f,
              :parent, :child_age, :current_diagnosis, :length_of_illness, :educational_program, :grad_date, :why_want,
              :child_experiences, :coteach_with, :teach_where)";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':applicant_id', $applicantId, PDO::PARAM_INT);
        $statement->bindParam(':conviction', $BAnswers->getConvictText(), PDO::PARAM_STR);
        $statement->bindParam(':taken_basics', $BAnswers->getTakenBasics(), PDO::PARAM_STR);
        $statement->bindParam(':taken_f2f', $BAnswers->getTakenF2F(), PDO::PARAM_STR);
        $statement->bindParam(':parent', $BAnswers->getParent(), PDO::PARAM_STR);
        $statement->bindParam(':child_age', $BAnswers->getChildAge(), PDO::PARAM_INT);
        $statement->bindParam(':current_diagnosis', $BAnswers->getCurrentDiagnosis(), PDO::PARAM_STR);
        $statement->bindParam(':length_of_illness', $BAnswers->getLengthOfIllness(), PDO::PARAM_STR);
        $statement->bindParam(':educational_program', $BAnswers->getEducationalProgram(), PDO::PARAM_STR);
        $statement->bindParam(':grad_date', $BAnswers->getGradDate(), PDO::PARAM_STR);
        $statement->bindParam(':why_want', $BAnswers->getWhyBasicsTeacher(), PDO::PARAM_STR);
        $statement->bindParam(':child_experiences', $BAnswers->getChildExperiences(), PDO::PARAM_STR);
        $statement->bindParam(':coteach_with', $BAnswers->getCoteachWith(), PDO::PARAM_STR);
        $statement->bindParam(':teach_where', $BAnswers->getTeachWhere(), PDO::PARAM_STR);
        $statement->execute();
    }






    //////////////////////////////////////////////////AFFILIATE/////////////////////////////////////////////////////////

    /**
     * Gets the affiliate's email
     *
     * @param $affiliateId int
     * @return mixed
     */
    function getAffiliateEmail($affiliateId)
    {
        //define query
        $query = "SELECT email FROM affiliates WHERE affiliate_id = :affiliate_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':affiliate_id', $affiliateId, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['email'];
    }

    /**
     * Gets the Affiliate's name
     *
     * @param $affiliateId int
     * @return mixed The name of the affiliate
     */
    function getAffiliateName($affiliateId)
    {
        //define query
        $query = "SELECT name FROM affiliates WHERE affiliate_id = :affiliate_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':affiliate_id', $affiliateId, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['name'];
    }

    /**
     * Updates the status of the applicant
     *
     * @param $status int the new status (look for what each int mean at the top)
     * @param $appId int the id of the applicant being updated
     */
    function updateApplicantStatus($status, $appId)
    {
        //define query
        $query = "UPDATE applicants SET app_status = :status WHERE applicant_id = :applicant_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        $statement->bindParam(':applicant_id', $appId, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param $appId int applicants id
     * @param $notes String notes written by affiliate
     */
    function insertAffiliateNotes($appId, $notes, $memExp)
    {
        $query = "UPDATE applicants SET notes = :notes, member_expiration = :memExp WHERE applicant_id = :applicant_id";

        $statement = $this->_dbh->prepare($query);

        $statement->bindParam(':notes', $notes, PDO::PARAM_STR);
        $statement->bindParam(':memExp', $memExp, PDO::PARAM_STR);
        $statement->bindParam(':applicant_id', $appId, PDO::PARAM_INT);

        $statement->execute();
    }

    ////////////////////////////////////////////////////ADMIN///////////////////////////////////////////////////////////

    /**
     * Inserts a new admin user
     *
     * @param $fname
     * @param $lname
     * @param $email
     * @param $password
     * @return mixed
     */
    function insertAdminUser($fname, $lname, $email, $password)
    {

        //hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        //define query
        $query = 'INSERT INTO adminUser
                  (fname, lname, email, password)
                  VALUES
                  (:fname, :lname, :email, :password)';

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);

        //execute statement
        $statement->execute();

        return $this->_dbh->lastInsertId();
    }

    /**
     * Gets the password associated with an admin account by email
     *
     * @param $email
     * @return mixed
     */
    function getAdminPassword($email)
    {
        //define query
        $query = "SELECT password, fname, lname 
                  FROM adminUser
                  WHERE email = :email";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if email exists in table
     *
     * @param $email
     * @return mixed
     */
    function getAdminEmail($email)
    {
        //define query
        $query = "SELECT email 
                  FROM adminUser
                  WHERE email = :email";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets all affiliates
     *
     * @return mixed
     */
    function getAffiliates()
    {
        //define query
        $query = "SELECT  name,affiliate_id, email FROM affiliates";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all application types
     *
     * @return mixed
     */
    function getAppTypes()
    {
        //define query
        $query = "SELECT app_id, app_type, ref_name FROM app_type";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all application types info that is active
     *
     * @return mixed
     */
    function getAppTypesInfo()
    {
        //define query
        $query = "SELECT info_id, date, location, deadline, app_type, date2, date3
                  FROM app_type_info
                  WHERE active = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all application types info that is old
     *
     * @return mixed
     */
    function getOldAppTypesInfo()
    {
        //define query
        $query = "SELECT info_id, date, location, deadline, app_type, date2, date3
                  FROM app_type_info
                  WHERE active = 0";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $infoId represents the info id
     * @return mixed
     */
    function getAppTypeInfo($infoId)
    {

        //define query
        $query = "SELECT date, location, deadline, app_type, date2, date3
                  FROM app_type_info
                  WHERE info_id = :infoId
                  AND active = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':infoId', $infoId, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new info/training for a specific application type
     *
     * @param $id
     * @param $date
     * @param $date2
     * @param $date3
     * @param $location
     * @param $deadline
     * @return mixed
     */
    function insertAppTypeInfo($id, $date, $date2, $date3, $location, $deadline)
    {

        //define query
        $query = 'INSERT INTO app_type_info
                  (date, location, deadline, app_type, date2, date3, active)
                  VALUES
                  (:date, :location, :deadline, :app_type, :date2, :date3, 1)';

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->bindParam(':date2', $date2, PDO::PARAM_STR);
        $statement->bindParam(':date3', $date3, PDO::PARAM_STR);
        $statement->bindParam(':location', $location, PDO::PARAM_STR);
        $statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
        $statement->bindParam(':app_type', $id, PDO::PARAM_STR);

        //execute statement
        $statement->execute();

        return $this->_dbh->lastInsertId();
    }

    /**
     * Delete an info/training for a specific application type
     *
     * @param $id
     * @return mixed
     */
    function deleteAppTypeInfo($id)
    {
        //define query
        $query = 'UPDATE app_type_info
                  SET active = 0
                  WHERE info_id = :info_id;';

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':info_id', $id, PDO::PARAM_STR);

        //execute statement
        return $statement->execute();
    }

    /**
     * Count number of trainings per app type
     *
     * @param $id
     * @return mixed
     */
    function countTrainingAppTypeInfo($id)
    {
        //define query
        $query = "SELECT COUNT(info_id) AS Trainings
                  FROM app_type_info
                  WHERE app_type = :id
                  AND active = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Count number of open trainings
     *
     * @return mixed
     */
    function countTrainings()
    {
        //define query
        $query = "SELECT COUNT(info_id) AS Trainings
                  FROM app_type_info
                  WHERE active = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * deletes affiliates
     *
     * @param $affiliate_id represents the id of the affiliate
     */

    function deleteAffiliate($affiliate_id)
    {

        $query = "DELETE FROM affiliates WHERE affiliate_id=:affiliate_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->bindParam(':affiliate_id', $affiliate_id, PDO::PARAM_INT);

        $statement->execute();

    }

    /**
     * This function edits the affiliate name and email
     *
     * @param $name represents the name of the affiliate
     * @param $email represents the affiliate's email
     * @param $affiliate_id represents the affiliate id
     */
    function updateAffiliate($name, $email, $affiliate_id)
    {
        $query = "UPDATE affiliates 
                  SET 
                  name= :name, 
                  email= :email
                  WHERE affiliate_id = :affiliate_id
                  LIMIT 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':affiliate_id', $affiliate_id, PDO::PARAM_INT);

        $statement->execute();

    }

    /**
     * adds an affiliate
     *
     * @param $name represents the name of the affiliate
     * @param $email represents the email of the affiliate
     */

    function addAffiliate($name, $email)
    {
        $query = "INSERT INTO affiliates (name, email)
                VALUES (:name, :email)";
        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Get all application types
     *
     * @return mixed
     */
    function getLocations()
    {
        //define query
        $query = "SELECT location, location_id FROM locations";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $location_id
     * @return mixed
     */
    function deleteLocation($location_id)
    {
        //define query
        $query = "DELETE FROM locations 
                    WHERE location_id = :location_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':location_id', $location_id, PDO::PARAM_INT);

        return $statement->execute();
    }


    /**
     * Adds a new location
     * @param $location
     */
    function addANewLocation($location)
    {

        //define query
        $query = "INSERT INTO locations (location)
                VALUES (:location)";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':location', $location, PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Updates the locations
     * @param $location_id
     */
    function updateLocation($location_id)
    {

        $queryNum = "SET 
                    @num := 0";
        $query = "UPDATE locations 
                  SET                   
                  location_id = @num := (@num + 1)";
        $query1 = "ALTER TABLE locations AUTO_INCREMENT = 1";

        //prepare statement
        $statementNum = $this->_dbh->prepare($queryNum);
        $statement = $this->_dbh->prepare($query);
        $statement1 = $this->_dbh->prepare($query1);

        //bind parameters
        $statement->bindParam(':location_id', $location_id, PDO::PARAM_INT);
        $statement1->bindParam(':location_id', $location_id, PDO::PARAM_INT);


        $statementNum->execute();
        $statement->execute();
        $statement1->execute();

    }

    /**
     * Edit a training date, location and deadline
     *
     * @param $info_id
     * @param $date represents the first day of training date
     * @param $date2 represents the second day of training (optional)
     * @param $date3 represents the third day of training (optional)
     * @param $location represents the location of the training
     * @param $deadline represents the deadline date for the training
     */
    function editAppTypeInfo($info_id, $date, $date2 = null, $date3 = null, $location, $deadline)
    {
        //define query
        $query = 'UPDATE app_type_info
                  SET 
                  date = :date,
                  location = :location,
                  deadline = :deadline,
                  date2 = :date2,
                  date3 = :date3
                  WHERE info_id = :info_id';

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->bindParam(':date2', $date2, PDO::PARAM_STR);
        $statement->bindParam(':date3', $date3, PDO::PARAM_STR);
        $statement->bindParam(':location', $location, PDO::PARAM_STR);
        $statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
        $statement->bindParam(':info_id', $info_id, PDO::PARAM_STR);

        //execute statement
        $statement->execute();
    }

    /**
     * Counts number of affiliates
     *
     * @return mixed
     */
    function countAffiliates()
    {
        //define query
        $query = "SELECT COUNT(affiliate_id) AS NumAffiliates
                  FROM affiliates";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get applicants based on category: active, waitlist, archive
     *
     * @param $category : active = 1, waitlist = 2, archive = 0
     * @return mixed
     */
    function getApplicants($category)
    {

        //affiliate->affiliates table
        //app_type->app_type table
        //applicant_id for viewing full and editing
        //define query
        $query = "SELECT 
                  applicant_id AS ID, 
                  app_status AS AppStatus, 
                  CONCAT(fname, ' ', lname) AS Name, 
                  affiliates.name AS Affiliate, 
                  affiliates.affiliate_id AS AffiliateID,
                  app_type.app_type AS Training, 
                  applicants.email AS Email, 
                  date_submitted AS DateSubmitted,
                  app_type_info.date AS Date,
                  category AS Category,
                  notes AS Notes
                  FROM applicants 
                  INNER JOIN affiliates ON applicants.affiliate = affiliates.affiliate_id
                  INNER JOIN app_type ON applicants.app_type = app_type.app_id
                  INNER JOIN app_type_info ON applicants.info_id = app_type_info.info_id
                  WHERE category = :category
                  AND applicants.affiliate = affiliates.affiliate_id
                  AND applicants.app_type = app_type.app_id
                  AND applicants.info_id = app_type_info.info_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':category', $category, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Counts number of applications
     *
     * @param $category : active = 1, waitlist = 2, archive = 0
     * @return mixed
     */
    function countApplicants($category)
    {
        //define query
        $query = "SELECT COUNT(category) AS NumApplicants
                  FROM applicants
                  WHERE category = :category";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->bindParam(':category', $category, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Counts number of submitted active applications
     *
     * @return mixed
     */
    function countSubmitted()
    {
        //define query
        $query = "SELECT COUNT(app_status) AS Submitted
                  FROM applicants
                  WHERE app_status = 1
                  AND category = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Counts number of approved active applications
     *
     * @return mixed
     */
    function countApproved()
    {
        //define query
        $query = "SELECT COUNT(app_status) AS Approved
                  FROM applicants
                  WHERE app_status = 2
                  AND category = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Counts number of denied active applications
     *
     * @return mixed
     */
    function countDenied()
    {
        //define query
        $query = "SELECT COUNT(app_status) AS Denied
                  FROM applicants
                  WHERE app_status = 0
                  AND category = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Counts number of complete active applications
     *
     * @return mixed
     */
    function countComplete()
    {
        //define query
        $query = "SELECT COUNT(app_status) AS Complete
                  FROM applicants
                  WHERE app_status = 3
                  AND category = 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();


        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Counts date month-year
     *
     * @return mixed
     */
    function countDate()
    {
        //define query
        //$query = "SELECT COUNT(date_submitted) As Submitted, EXTRACT(YEAR_MONTH FROM date_submitted) AS MonthYear FROM applicants;";
        $query = "SELECT concat(month(date_submitted),'/', year(date_submitted)) as MonthYear FROM applicants 
                    GROUP BY MonthYear
                    ORDER BY date_submitted";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();


        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Counts date month-year
     *
     * @return mixed
     */
    function countApplicationByMonthYear()
    {
        //define query
        //$query = "SELECT COUNT(date_submitted) As Submitted, EXTRACT(YEAR_MONTH FROM date_submitted) AS MonthYear FROM applicants;";
        $query = "SELECT COUNT(applicant_id) AS AppSubmit FROM applicants 
                    GROUP BY EXTRACT(YEAR_MONTH FROM applicants.date_submitted) 
                    ORDER BY EXTRACT(YEAR_MONTH FROM applicants.date_submitted)";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();


        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update applicant category or status
     *
     * @param $id
     * @param $category
     * @param $status
     */
    function updateApplicant($id, $category, $status, $notes)
    {
        //define query
        $query = "UPDATE applicants 
                  SET 
                  app_status = :status,
                  category = :category,
                  notes = :notes
                  WHERE applicant_id = :id
                  LIMIT 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameters
        $statement->bindParam(':category', $category, PDO::PARAM_INT);
        $statement->bindParam(':status', $status, PDO::PARAM_INT);
        $statement->bindParam(':notes', $notes, PDO::PARAM_INT);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();
    }

    //////////////////////////////////////////////////GENERAL///////////////////////////////////////////////////////////

    /**
     * Gets the applicant by ID
     *
     * @param $appID int
     * @return mixed the array for the applicant
     */
    function getApplicant($appID)
    {

        //define query
        $query = "SELECT *,
                  affiliates.name AS Affiliate,
                  app_type.app_type AS Training,
                  app_type.ref_name AS Reference,
                  applicants.email AS Email,
                  app_type_info.date AS Day1,
                  app_type_info.date2 AS Day2,
                  app_type_info.date3 AS Day3,
                  app_type_info.location AS Location
                  FROM applicants
                  INNER JOIN affiliates ON applicants.affiliate = affiliates.affiliate_id
                  INNER JOIN app_type ON applicants.app_type = app_type.app_id
                  INNER JOIN app_type_info ON applicants.info_id = app_type_info.info_id
                  WHERE applicant_id = :appID
                  AND applicants.affiliate = affiliates.affiliate_id
                  AND applicants.app_type = app_type.app_id
                  AND applicants.info_id = app_type_info.info_id";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':appID', $appID, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $applicationId
     * @param $expiration
     * @param $leaderName
     * @param $leaderTitle
     * @param $type
     * @param $date
     * @param $check
     */
    function updateApprovalInfo($applicationId, $expiration, $leaderName, $leaderTitle, $type, $date, $check)
    {
        $sql = "UPDATE applicants SET app_status = 2, member_expiration = :member_expiration, 
                      approver_name = :approver_name, approver_title = :approver_title, 
                      affiliate_type = :affiliate_type, approval_date = :approval_date, check_number = :check_number
                    WHERE applicant_id = :applicant_id";
        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':member_expiration', $expiration, PDO::PARAM_STR);
        $statement->bindParam(':approver_name', $leaderName, PDO::PARAM_STR);
        $statement->bindParam(':approver_title', $leaderTitle, PDO::PARAM_STR);
        $statement->bindParam(':affiliate_type', $type, PDO::PARAM_STR);
        $statement->bindParam(':approval_date', $date, PDO::PARAM_STR);
        $statement->bindParam(':check_number', $check, PDO::PARAM_INT);
        $statement->bindParam(':applicant_id', $applicationId, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param $applicationId int
     * @return mixed array with all the applicants
     */
    function getTrainingInfo($applicationId)
    {
        //name, phone, email, special needs, and all rooming info
        //define query
        $query = "SELECT date_submitted, app_status, fname, pname, lname, primary_phone, email, 
                special_needs, service_animal, mobility_need, need_rooming,
                single_room, days_rooming, gender, roommate_gender, 
                cpap_user, roommate_cpap
                FROM applicants
                WHERE app_type = :app_type";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //only get complete applications
        //$app_status = 3;

        //bind parameter
        $statement->bindParam(':app_type', $applicationId, PDO::PARAM_INT);
        //$statement->bindParam(':app_status', $app_status, PDO::PARAM_INT);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i]['app_status'] == 0) {
                $result[$i]['app_status'] = "denied";
            } else if ($result[$i]['app_status'] == 1) {
                $result[$i]['app_status'] = "submitted";
            } else if ($result[$i]['app_status'] == 2) {
                $result[$i]['app_status'] = "approved";
            } else if ($result[$i]['app_status'] == 3) {
                $result[$i]['app_status'] = "completed";
            }
        }

        return $result;
    }

    /**
     * @param $applicant_id
     * @param $application_type
     * @return mixed
     */
    function getLongAnswer($applicant_id, $application_type)
    {
        //tables
        define('FSG', 1);
        define('P2P', 2);
        define('ETS', 3);
        define('C', 4);
        define('IOOV', 5);
        define('PE', 6);
        define('F2F', 7);
        define('H', 8);
        define('B', 9);

        $query = '';

        //find the right table
        if ($application_type == FSG) {
            //define query
            $query = "SELECT *
                      FROM FSG
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == P2P) {
            //define query
            $query = "SELECT *
                      FROM P2P
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == ETS) {
            //define query
            $query = "SELECT *
                      FROM ETS
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == C) {
            //define query
            $query = "SELECT *
                      FROM C 
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == IOOV) {
            //define query
            $query = "SELECT *
                      FROM IOOV
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == PE) {
            $query = "SELECT *
             FROM PE
             WHERE applicant_id = :applicant_id";
        } else if ($application_type == F2F) {
            $query = "SELECT *
             FROM F2F
             WHERE applicant_id = :applicant_id";
        } else if ($application_type == B) {
            //define query
            $query = "SELECT *
                      FROM B
                      WHERE applicant_id = :applicant_id";
        } else if ($application_type == H) {
            $query = "SELECT *
             FROM H
             WHERE applicant_id = :applicant_id";
        }

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        //bind parameter
        $statement->bindParam(':applicant_id', $applicant_id, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $app_type int application id
     * @return mixed
     */
    function getRefName($app_type)
    {
        $sql = "SELECT ref_name FROM app_type WHERE app_id = :app_id";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':app_id', $app_type, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return Name/percentage of the top five affiliates with the most pending applications
     */
    ////////////the first///////////

    //name//

    function getTheFirstSlacker()
    {
        //define query
        $query = "SELECT affiliates.name as affiliateName1 from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP by affiliate
                    ORDER by COUNT(category) DESC
                    LIMIT 1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //percentage//
    function getTheFirstPercentage()
    {
        $query = "SELECT
                    ROUND((((SELECT COUNT(app_type) from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 1)/
                    (SELECT COUNT(app_type) as firstPercentage from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 1))*100),0)
                    as firstPercentage";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    ////////////the second////////////

    //name//
    function getTheSecondSlacker()
    {
        //define query
        $query = "SELECT affiliates.name as affiliateName2 from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP by affiliate
                    ORDER by COUNT(category) DESC
                    LIMIT 1,1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //percentage//
    function getTheSecondPercentage()
    {
        $query = "SELECT
                    ROUND((((SELECT COUNT(app_type) from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 1,1)/
                    (SELECT COUNT(app_type) as firstPercentage from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 1,1))*100),0)
                    as secondPercentage";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    ////////////the third////////////

    //name//
    function getTheThirdSlacker()
    {
        //define query
        $query = "SELECT affiliates.name as affiliateName3 from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP by affiliate
                    ORDER by COUNT(category) DESC
                    LIMIT 2,1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //percentage//
    function getTheThirdPercentage()
    {
        $query = "SELECT
                    ROUND((((SELECT COUNT(app_type) from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 2,1)/
                    (SELECT COUNT(app_type) as firstPercentage from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 2,1))*100),0)
                    as thirdPercentage";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    ////////////the fourth////////////

    //name//
    function getTheFourthSlacker()
    {
        //define query
        $query = "SELECT affiliates.name as affiliateName4 from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP by affiliate
                    ORDER by COUNT(category) DESC
                    LIMIT 3,1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //percentage//
    function getTheFourthPercentage()
    {
        $query = "SELECT
                    ROUND((((SELECT COUNT(app_type) from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 3,1)/
                    (SELECT COUNT(app_type) as firstPercentage from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 3,1))*100),0)
                    as fourthPercentage";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    ////////////the fifth////////////

    //name//
    function getTheFifthSlacker()
    {
        //define query
        $query = "SELECT affiliates.name as affiliateName5 from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP by affiliate
                    ORDER by COUNT(category) DESC
                    LIMIT 4,1";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //percentage//
    function getTheFifthPercentage()
    {
        $query = "SELECT
                    ROUND((((SELECT COUNT(app_type) from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    WHERE app_type = 1
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 4,1)/
                    (SELECT COUNT(app_type) as firstPercentage from applicants
                    INNER JOIN  affiliates ON affiliates.affiliate_id = applicants.affiliate
                    GROUP BY affiliate
                    ORDER BY COUNT(app_type) DESC
                    LIMIT 4,1))*100),0)
                    as fifthPercentage";

        //prepare statement
        $statement = $this->_dbh->prepare($query);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getAdminInfo($email)
    {
        $sql = "SELECT * FROM adminUser WHERE email = :email";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function changeAdminPassword($adminId, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE adminUser SET password = :password WHERE admin_id = :admin_id";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

        $statement->execute();
    }

    //Get Edit Questions
    function getBQs()
    {
        $sql = "SELECT q2, q2a, q3, q4, q7, q7a, q7b, q7c, q7c, q7d, 
       q8, q8a, q9, q9a, q10, q11, q12, q12a, q13, q13a FROM B_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getCQs()
    {
        $sql = "SELECT q2, q3, q3note, q6 FROM C_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getETSQs()
    {
        $sql = "SELECT q2, q2a, q3, q4, q4a, q4b, q4c, q4d, q5, q6, q7, q8, q9, q10, q11, q12, q13 FROM ETS_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getF2FQs()
    {
        $sql = "SELECT q2, q2a, q3, q3note, q3a, q3b, q4, q4note, q7, q8, q8a, q9, q9a FROM F2F_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getFSGQs()
    {
        $sql = "SELECT q1, q1a, q3, q3a, q4, q5, q8, q8a, q9, q9a FROM FSG_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getHQs()
    {
        $sql = "SELECT q1, q1a, q2, q2note, q2a, q2b, q3, q3note, q6, q7, q7a, q8, q8a FROM H_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    function getIOOVQs()
    {
        $sql = "SELECT q2, q2a, q5, q5a, q5b, q5c, q5d, q5e, 
       q5f, q5g, q6, q7, q8, q9, q10, q11 FROM IOOV_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getP2PQs()
    {
        $sql = "SELECT q2, q2a, q4, q5, q6  FROM P2P_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function getPEQs()
    {
        $sql = "SELECT q2, q2a, q5, q6, q6a, q6b, q6c, q6d, q6e, q6f, q6g, q6h, q6i, q7, q8, q9, q10 FROM PE_Qs";
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    //Update questions
    function updateQs($type, $question, $newText)
    {
        $sql = "UPDATE " . $type . "_Qs
        SET " . $question . " = :newText
        WHERE id = 1";

        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':newText', $newText, PDO::PARAM_STR);

        $statement->execute();
    }
}