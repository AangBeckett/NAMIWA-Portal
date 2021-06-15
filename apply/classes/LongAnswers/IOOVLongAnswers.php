<?php

/**
 * @author Imelda Medina
 * @version 1.0
 * Class IOOVLongAnswers
 */
class IOOVLongAnswers
{
    private $_convict;
    private $_convictText;
    private $_degree;
    private $_volunteerExperience ;
    private $_diagnose ;
    private $_diagnoseTime ;
    private $_currentDiagnosis ;
    private $_hospitalized ;
    private $_recently;
    private $_speakingExperience ;
    private $_comfortable ;
    private $_transportation ;
    private $_notWantPresent ;
    private $_whyPresenter ;
    private $_stayedRecover ;
    private $_recovery ;


    /**
     * IOOVLongAnswers constructor.
     * @param $_convict
     * @param $_convictText
     * @param $_degree
     * @param $_volunteerExperience
     * @param $_diagnose
     * @param $_diagnoseTime
     * @param $_currentDiagnosis
     * @param $_hospitalized
     * @param $_recently
     * @param $_speakingExperience
     * @param $_comfortable
     * @param $_transportation
     * @param $_notWantPresent
     * @param $_whyPresenter
     * @param $_stayedRecover
     * @param $_recovery
     */
    public function __construct($_convict, $_convictText, $_degree, $_volunteerExperience, $_diagnose, $_diagnoseTime, $_currentDiagnosis, $_hospitalized, $_recently, $_speakingExperience, $_comfortable, $_transportation, $_notWantPresent, $_whyPresenter, $_stayedRecover, $_recovery )
    {
        $this->_convict = $_convict;
        $this->_convictText = $_convictText;
        $this->_degree = $_degree;
        $this->_volunteerExperience = $_volunteerExperience;
        $this->_diagnose = $_diagnose;
        $this->_diagnoseTime = $_diagnoseTime;
        $this->_currentDiagnosis = $_currentDiagnosis;
        $this->_hospitalized = $_hospitalized;
        $this->_recently = $_recently;
        $this->_speakingExperience = $_speakingExperience;
        $this->_comfortable = $_comfortable;
        $this->_transportation = $_transportation;
        $this->_notWantPresent = $_notWantPresent;
        $this->_whyPresenter = $_whyPresenter;
        $this->_stayedRecover = $_stayedRecover;
        $this->_recovery = $_recovery;
    }

    /**
     * Getter to get if the volunteer is a convict
     * @return mixed
     */
    public function getConvict()
    {
        return $this->_convict;
    }

    /**
     * Getter to get text if convict
     * @return mixed
     */
    public function getConvictText()
    {
        return $this->_convictText;
    }

    /**
     * Getter to get degree of volunteer
     * @return mixed
     */
    public function getDegree()
    {
        return $this->_degree;
    }

    /**
     * Getter to get volunteer Experience
     * @return mixed
     */
    public function getVolunteerExperience()
    {
        return $this->_volunteerExperience;
    }

    /**
     * Getter to get diagnose of the volunteer
     * @return mixed
     */
    public function getDiagnose()
    {
        return $this->_diagnose;
    }

    /**
     * Getter to get the age of the
     * volunteer when diagnose
     * @return mixed
     */
    public function getDiagnoseTime()
    {
        return $this->_diagnoseTime;
    }

    /**
     * Getter to get the volunteer's
     * current diagnose
     * @return mixed
     */
    public function getCurrentDiagnosis()
    {
        return $this->_currentDiagnosis;
    }

    /**
     * Getter to get Hospitalization
     * @return mixed
     */
    public function getHospitalized()
    {
        return $this->_hospitalized;
    }

    /**
     * Getter to get if it was
     * recently hospitalized
     * @return mixed
     */
    public function getRecently()
    {
        return $this->_recently;
    }

    /**
     * Getter to get the volunteer
     * speaking experience
     * @return mixed
     */
    public function getSpeakingExperience()
    {
        return $this->_speakingExperience;
    }

    /**
     * Getter to get the text of
     * speaking experience level
     * @return mixed
     */
    public function getComfortable()
    {
        return $this->_comfortable;
    }

    /**
     * Getter to get transportation
     * @return mixed
     */
    public function getTransportation()
    {
        return $this->_transportation;
    }

    /**
     * Getter to get were the volunteer
     * doesn't want to present
     * @return mixed
     */
    public function getNotWantPresent()
    {
        return $this->_notWantPresent;
    }

    /**
     * Getter to get why it wants
     * to become a presenter
     * @return mixed
     */
    public function getWhyPresenter()
    {
        return $this->_whyPresenter;
    }

    /**
     * Getter to get how long
     * the volunteer has stayed recover
     * @return mixed
     */
    public function getStayedRecover()
    {
        return $this->_stayedRecover;
    }

    /**
     * Getter to get recovery
     * @return mixed
     */
    public function getRecovery()
    {
        return $this->_recovery;
    }


}