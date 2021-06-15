<?php
global $f3;

if(!empty($_POST))
{
    // get data from form
    $whyFacilitator = $_POST['whyFacilitator'];
    $experience = $_POST['experience'];
    $description = $_POST['description'];

    //add data to hive
    $f3->set('whyFacilitator', $whyFacilitator);
    $f3->set('experience', $experience);
    $f3->set('description', $description);

    $_SESSION['LongAnswer'] =  new CLongAnswers($whyFacilitator, $experience, $description);

    if(validCLongAnswersForm())
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
    $_SESSION['LongAnswer'] = new CLongAnswers('','', '');
}
