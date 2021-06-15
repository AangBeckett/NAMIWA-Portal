<?php
/**
 * Class for PELongAnswers training long answers
 * @author Maureen Kariuki
 * @version 06/14/2020
 */
class PELongAnswers
{

    private $_convict;
    private $_convictText;
    private $_availability;
    private $_degree;
    private $_volunteerExperience;
    private $_fluentLanguage;
    private $_youngAdult;
    private $_describes;
    private $_currentDiagnosis;
    private $_disclosure;
    private $_outlook;
    private $_background;
    private $_presenterText;
    private $_frontLineExperienceText;
    private $_supportiveExperienceText;
    private $_recoveryText;

    /**
     * PELongAnswers constructor.
     * @param $_convict
     * @param $_convictText
     * @param $_availability
     * @param $_degree
     * @param $_volunteerExperience
     * @param $_fluentLanguage
     * @param $_youngAdult
     * @param $_describes
     * @param $_currentDiagnosis
     * @param $_disclosure
     * @param $_outlook
     * @param $_background
     * @param $_presenterText
     * @param $_frontLineExperienceText
     * @param $_supportiveExperienceText
     * @param $_recoveryText
     */
    public function __construct($_convict, $_convictText, $_availability, $_degree, $_volunteerExperience,
                                $_fluentLanguage, $_youngAdult, $_describes, $_currentDiagnosis, $_disclosure,
                                $_outlook, $_background, $_presenterText, $_frontLineExperienceText,
                                $_supportiveExperienceText, $_recoveryText)
    {
        $this->_convict = $_convict;
        $this->_convictText = $_convictText;
        $this->_availability = $_availability;
        $this->_degree = $_degree;
        $this->_volunteerExperience = $_volunteerExperience;
        $this->_fluentLanguage = $_fluentLanguage;
        $this->_youngAdult = $_youngAdult;
        $this->_describes = $_describes;
        $this->_currentDiagnosis = $_currentDiagnosis;
        $this->_disclosure = $_disclosure;
        $this->_outlook = $_outlook;
        $this->_background = $_background;
        $this->_presenterText = $_presenterText;
        $this->_frontLineExperienceText = $_frontLineExperienceText;
        $this->_supportiveExperienceText = $_supportiveExperienceText;
        $this->_recoveryText = $_recoveryText;
    }

    /**
     * @return mixed
     */
    public function getConvict()
    {
        return $this->_convict;
    }

    /**
     * @param mixed $convict
     */
    public function setConvict($convict)
    {
        $this->_convict = $convict;
    }

    /**
     * @return mixed
     */
    public function getConvictText()
    {
        return $this->_convictText;
    }

    /**
     * @param mixed $convictText
     */
    public function setConvictText($convictText)
    {
        $this->_convictText = $convictText;
    }

    /**
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->_availability;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability)
    {
        $this->_availability = $availability;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->_degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree)
    {
        $this->_degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getVolunteerExperience()
    {
        return $this->_volunteerExperience;
    }

    /**
     * @param mixed $volunteerExperience
     */
    public function setVolunteerExperience($volunteerExperience)
    {
        $this->_volunteerExperience = $volunteerExperience;
    }

    /**
     * @return mixed
     */
    public function getFluentLanguage()
    {
        return $this->_fluentLanguage;
    }

    /**
     * @param mixed $fluentLanguage
     */
    public function setFluentLanguage($fluentLanguage)
    {
        $this->_fluentLanguage = $fluentLanguage;
    }

    /**
     * @return mixed
     */
    public function getYoungAdult()
    {
        return $this->_youngAdult;
    }

    /**
     * @param mixed $youngAdult
     */
    public function setYoungAdult($youngAdult)
    {
        $this->_youngAdult = $youngAdult;
    }

    /**
     * @return mixed
     */
    public function getDescribes()
    {
        return $this->_describes;
    }

    /**
     * @param mixed $describes
     */
    public function setDescribes($describes)
    {
        $this->_describes = $describes;
    }

    /**
     * @return mixed
     */
    public function getCurrentDiagnosis()
    {
        return $this->_currentDiagnosis;
    }

    /**
     * @param mixed $currentDiagnosis
     */
    public function setCurrentDiagnosis($currentDiagnosis)
    {
        $this->_currentDiagnosis = $currentDiagnosis;
    }

    /**
     * @return mixed
     */
    public function getDisclosure()
    {
        return $this->_disclosure;
    }

    /**
     * @param mixed $disclosure
     */
    public function setDisclosure($disclosure)
    {
        $this->_disclosure = $disclosure;
    }

    /**
     * @return mixed
     */
    public function getOutlook()
    {
        return $this->_outlook;
    }

    /**
     * @param mixed $outlook
     */
    public function setOutlook($outlook)
    {
        $this->_outlook = $outlook;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->_background;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background)
    {
        $this->_background = $background;
    }

    /**
     * @return mixed
     */
    public function getPresenterText()
    {
        return $this->_presenterText;
    }

    /**
     * @param mixed $presenterText
     */
    public function setPresenterText($presenterText)
    {
        $this->_presenterText = $presenterText;
    }

    /**
     * @return mixed
     */
    public function getFrontLineExperienceText()
    {
        return $this->_frontLineExperienceText;
    }

    /**
     * @param mixed $frontLineExperienceText
     */
    public function setFrontLineExperienceText($frontLineExperienceText)
    {
        $this->_frontLineExperienceText = $frontLineExperienceText;
    }

    /**
     * @return mixed
     */
    public function getSupportiveExperienceText()
    {
        return $this->_supportiveExperienceText;
    }

    /**
     * @param mixed $supportiveExperienceText
     */
    public function setSupportiveExperienceText($supportiveExperienceText)
    {
        $this->_supportiveExperienceText = $supportiveExperienceText;
    }

    /**
     * @return mixed
     */
    public function getRecoveryText()
    {
        return $this->_recoveryText;
    }

    /**
     * @param mixed $recoveryText
     */
    public function setRecoveryText($recoveryText)
    {
        $this->_recoveryText = $recoveryText;
    }
}