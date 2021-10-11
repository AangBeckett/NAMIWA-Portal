<?php

//$user = $_SERVER['USER'];
$user = get_current_user();
require "/home/$user/config_email.php";

/**
 * Class Emailer Handles using SwiftMailer to email the applicant and affiliate
 * @author Maxwell Lee
 * @author Trang Luu
 * @author Olivia Ringhiser
 * @author Dhruv Kapu
 * Date: 7/1/2021
 */
class Emailer
{
    /**
     * Handles sending the affiliate an email to review an application
     * @param $applicantId int ID of the applicant
     * @param $fname String first name
     * @param $lname String last name
     * @param $affiliate int affiliate's id
     * @param $db UnamiDatabase The database we are using
     */
    static function sendAffiliateEmail($applicantId, $fname, $lname, $affiliate, $db)
    {
        $hashedId = password_hash($applicantId, PASSWORD_BCRYPT);
        $linkHashedId = str_replace('/', '-', $hashedId);
        $applicantName = $fname . ' ' . $lname;

        $applicant = $db->getApplicant($applicant_id);

        $app_type = $applicant['app_type'];

        $toEmail = $db->getAffiliateEmail($affiliate);
        $toEmailAlias = $db->getAffiliateName($affiliate);

        $mental_condition = "an individual with a mental health condition.";
        if ($app_type == "Family Support Group" || $app_type == "Family-to-Family" || $app_type == "Basics") {
            $mental_condition = "a family member of an individual with a mental health condition.";
        }
        if ($app_type == "Peer-to-Peer" || $app_type == "In Our Own Voice") {
            $mental_condition = "an individual with a mental health condition.";
        }
        if ($app_type == "Ending the Silence") {
            $mental_condition = "either an individual between 18 and 35 who identifies with a mental health condition; or a Adult who is either individual who identifies with a mental health condition or is a family member of someone who does.";
        }
        if ($app_type == "Provider Education") {
            $mental_condition = "an individual with a mental health condition, family member of an individual with a mental health condition, or a mental health professional who is either an individual/family member of someone with a condition. Every affiliate with applicants must have at least one applicant from each of these groups.";
        }
        if ($app_type == "Homefront") {
            $mental_condition = "a family member of a veteran with a mental health condition.";
        }

        try {
            $message = (new Swift_Message('Review Application: ' . $applicantName))
                ->setFrom([EMAIL_USERNAME => 'UNAMI: DO-NOT-REPLY'])
                ->setTo([$toEmail => $toEmailAlias]);


            $cid = $message->embed(Swift_Image::fromPath('http://apply.namiwa.org/apply/images/namiLogo.png',
                'image.png', 'image/png'));

            $body = <<<EOD
        <html lang="en">
            <body>
                <div style="background-color: #0c499c">
                    <img src="$cid" alt="NAMI WA Logo">
                </div>
                
                <div>
                    <p>Dear Team $affiliate,
                    
                    There is a new application for $fname $lname who has applied for the $app_type state training.

                    Please make sure you’ve verified their membership either prior to or during the interview. If they are
                    not a member before the interview, please review with your affiliate leader how to process their
                    membership so you can do so during the interview.

                    Your affiliate may already have questions, if not please click <a href="https://www.nami.org/Extranet/Education-Training-and-Outreach-Programs/EduHelpDesk/Guides-and-Directories"> here </a> to
                    review the questions recommended by NAMI.

                    During your interview please verify the following:

                    1) Applicant fully understands the program they are facilitating.
                    2) Applicant identifies as $mental_condition
                    3) That they applied to be the facilitator not just attend the program.
                    4) They are able to attend all training dates and do not plan on missing anything.
                    5) They will volunteer with your affiliate for two years and what your expectations as an affiliate
                    are for them.

                    Click <a href="http://apply.namiwa.org/apply/affiliate_review/$applicantId/$linkHashedId">here</a> to review and approve their application.

                    If you have any questions please reach out to me directly

                    [Insert Matt’s Email signature]
                    </p>
                </div>
            </body>
        </html>
EOD;

            $message->setBody($body, 'text/html');
            $message->addPart('Please review ' . $applicantName . "'s application: 
            http://apply.namiwa.org/apply/" . $applicantId . '/' . $linkHashedId, 'text/plain');

            $transport = (new Swift_SmtpTransport(EMAIL_SERVER, 465, 'ssl'))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD);

            $mailer = new Swift_Mailer($transport);

            //sends the email
            $mailer->send($message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Handles sending the applicant a confirmation email
     * @param $personalInfo PersonalInfo The personal info from the form
     */
    static function sendConfirmationEmail($personalInfo)
    {
        $toEmail = $personalInfo->getEmail();
        $member = $personalInfo->getMember();
        $toEmailName = $personalInfo->getFname() . ' ' . $personalInfo->getLname();

        try {

            $message = (new Swift_Message('UNAMI application'))
                ->setFrom([EMAIL_USERNAME => 'UNAMI: DO-NOT-REPLY'])
                ->setTo([$toEmail => $toEmailName]);
            $cid = $message->embed(Swift_Image::fromPath('http://apply.namiwa.org/apply/images/namiLogo.png',
                'image.png', 'image/png'));

            if ($member == "yes") {
                $body = <<<EOD
        <html lang="en">
            <body>
                <div style="background-color: #0c499c">
                    <img src="$cid" alt="NAMI WA Logo">
                </div>
                
                <div>
                    <p><center>Thank you for sending your application!</center></p><br>
                </div>
            </body>
        </html>
EOD;
            } else {
                $body = <<<EOD
        <html lang="en">
            <body>
                <div style="background-color: #0c499c">
                    <img src="$cid" alt="NAMI WA Logo">
                </div>
                
                <div>
                    <p><center>Thank you for sending your application!</center></p><br>
                    
                    <p><center>If you're not a NAMI member, please sign-up 
                    <a href="https://www.nami.org/Get-Involved/Join">here
                    </a> to complete the training with NAMI.</center></p>
                </div>
            </body>
        </html>
EOD;
            }

            $message->setBody($body, 'text/html');


            $transport = (new Swift_SmtpTransport(EMAIL_SERVER, 465, 'ssl'))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD);
            $mailer = new Swift_Mailer($transport);

            $mailer->send($message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    static function sendResetEmail($email, $db)
    {
        $adminInfo = $db->getAdminInfo($email);
        $adminID = $adminInfo['admin_id'];
        $hashedId = password_hash($adminID, PASSWORD_BCRYPT);
        $linkHashedId = str_replace('/', '-', $hashedId);
        $applicantName = $adminInfo['fname'] . ' ' . $adminInfo['lname'];

        $toEmail = $email;
        $toEmailAlias = $applicantName;

        try {
            $message = (new Swift_Message('Reset Password: ' . $applicantName))
                ->setFrom([EMAIL_USERNAME => 'UNAMI: DO-NOT-REPLY'])
                ->setTo([$toEmail => $toEmailAlias]);


            $cid = $message->embed(Swift_Image::fromPath('http://apply.namiwa.org/apply/images/namiLogo.png',
                'image.png', 'image/png'));

            $body = <<<EOD
        <html lang="en">
            <body>
                <div style="background-color: #0c499c">
                    <img src="$cid" alt="NAMI WA Logo">
                </div>
                
                <div>
                    <p>Reset your password by following this link: 
                    <a href="http://apply.namiwa.org/apply/reset-password/$adminID/$linkHashedId">Here</a></p>
                </div>
            </body>
        </html>
EOD;

            $message->setBody($body, 'text/html');
            $message->addPart('Reset Password: ' . $applicantName . ": 
             http://apply.namiwa.org/apply/reset-password/" . $adminID . '/' . $linkHashedId, 'text/plain');

            $transport = (new Swift_SmtpTransport(EMAIL_SERVER, 465, 'ssl'))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD);

            $mailer = new Swift_Mailer($transport);

            //sends the email
            $mailer->send($message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
