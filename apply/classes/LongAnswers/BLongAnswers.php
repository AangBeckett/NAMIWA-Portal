<?php

/**
 * Class BLongAnswers Holds all the answers from the B long answers
 * @author Olivia Ringhiser
 * Date: 5/10/2020
 */
class BLongAnswers
{
    private $_convict;
    private $_convictText;
    private $_takenBasics;
    private $_takenF2F;
    private $_parent;
    private $_childAge;
    private $_givenDiagnosis;
    private $_currentDiagnosis;
    private $_lengthOfIllness;
    private $_publicSchool;
    private $_educationalProgram;
    private $_highSchoolGrad;
    private $_gradDate;
    private $_whyBasicsTeacher;
    private $_childExperiences;
    private $_coteach;
    private $_coteachWith;
    private $_knowWhere;
    private $_teachWhere;

    /**
     * BLongAnswers constructor.
     * @param $_convict
     * @param $_convictText
     * @param $_takenBasics
     * @param $_takenF2F
     * @param $_parent
     * @param $_childAge
     * @param $_givenDiagnosis
     * @param $_currentDiagnosis
     * @param $_lengthOfIllness
     * @param $_publicSchool
     * @param $_educationalProgram
     * @param $_highSchoolGrad
     * @param $_gradDate
     * @param $_whyBasicsTeacher
     * @param $_childExperiences
     * @param $_coteach
     * @param $_coteachWith
     * @param $_knowWhere
     * @param $_teachWhere
     */
    public function __construct($_convict, $_convictText, $_takenBasics, $_takenF2F, $_parent, $_childAge, $_givenDiagnosis,
                                $_currentDiagnosis, $_lengthOfIllness, $_publicSchool, $_educationalProgram,
                                $_highSchoolGrad, $_gradDate, $_whyBasicsTeacher, $_childExperiences, $_coteach,
                                $_coteachWith, $_knowWhere, $_teachWhere)
    {
        $this->_convict = $_convict;
        $this->_convictText = $_convictText;
        $this->_takenBasics = $_takenBasics;
        $this->_takenF2F = $_takenF2F;
        $this->_parent = $_parent;
        $this->_childAge = $_childAge;
        $this->_givenDiagnosis = $_givenDiagnosis;
        $this->_currentDiagnosis = $_currentDiagnosis;
        $this->_lengthOfIllness = $_lengthOfIllness;
        $this->_publicSchool = $_publicSchool;
        $this->_educationalProgram = $_educationalProgram;
        $this->_highSchoolGrad = $_highSchoolGrad;
        $this->_gradDate = $_gradDate;
        $this->_whyBasicsTeacher = $_whyBasicsTeacher;
        $this->_childExperiences = $_childExperiences;
        $this->_coteach = $_coteach;
        $this->_coteachWith = $_coteachWith;
        $this->_knowWhere = $_knowWhere;
        $this->_teachWhere = $_teachWhere;
    }

    /**
     * @return mixed
     */
    public function getConvict()
    {
        return $this->_convict;
    }

    /**
     * @return mixed
     */
    public function getConvictText()
    {
        return $this->_convictText;
    }

    /**
     * @return mixed
     */
    public function getTakenBasics()
    {
        return $this->_takenBasics;
    }

    /**
     * @return mixed
     */
    public function getTakenF2F()
    {
        return $this->_takenF2F;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * @return mixed
     */
    public function getChildAge()
    {
        return $this->_childAge;
    }

    /**
     * @return mixed
     */
    public function getGivenDiagnosis()
    {
        return $this->_givenDiagnosis;
    }

    /**
     * @return mixed
     */
    public function getCurrentDiagnosis()
    {
        return $this->_currentDiagnosis;
    }

    /**
     * @return mixed
     */
    public function getPublicSchool()
    {
        return $this->_publicSchool;
    }

    /**
     * @return mixed
     */
    public function getLengthOfIllness()
    {
        return $this->_lengthOfIllness;
    }

    /**
     * @return mixed
     */
    public function getEducationalProgram()
    {
        return $this->_educationalProgram;
    }

    /**
     * @return mixed
     */
    public function getHighSchoolGrad()
    {
        return $this->_highSchoolGrad;
    }

    /**
     * @return mixed
     */
    public function getGradDate()
    {
        return $this->_gradDate;
    }

    /**
     * @return mixed
     */
    public function getWhyBasicsTeacher()
    {
        return $this->_whyBasicsTeacher;
    }

    /**
     * @return mixed
     */
    public function getChildExperiences()
    {
        return $this->_childExperiences;
    }

    /**
     * @return mixed
     */
    public function getCoteach()
    {
        return $this->_coteach;
    }

    /**
     * @return mixed
     */
    public function getCoteachWith()
    {
        return $this->_coteachWith;
    }

    /**
     * @return mixed
     */
    public function getKnowWhere()
    {
        return $this->_knowWhere;
    }

    /**
     * @return mixed
     */
    public function getTeachWhere()
    {
        return $this->_teachWhere;
    }

}