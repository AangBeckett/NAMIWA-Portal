<?php

/**
 * Class HLongAnswers Holds all the answers from the H long answers
 * @author Olivia Ringhiser
 * Date: 5/9/2020
 */
class HLongAnswers
{
    private $_convict;
    private $_convictText;
    private $_takenF2F;
    private $_familyMember;
    private $_relationship;
    private $_diagnosis;
    private $_whyHomefrontTeacher;
    private $_coteach;
    private $_coteachWith;
    private $_knowWhere;
    private $_teachWhere;


    /**
     * HLongAnswers constructor.
     * @param $_convict
     * @param $_convictText
     * @param $_familyMember
     * @param $_relationship
     * @param $_diagnosis
     * @param $_takenF2F
     * @param $_whyHomefrontTeacher
     * @param $_coteach
     * @param $_coteachWith
     * @param $_knowWhere
     * @param $_teachWhere
     */
    public function __construct($_convict, $_convictText, $_familyMember, $_relationship, $_diagnosis, $_takenF2F,
                                $_whyHomefrontTeacher, $_coteach, $_coteachWith, $_knowWhere, $_teachWhere)
    {
        $this->_convict = $_convict;
        $this->_convictText = $_convictText;
        $this->_takenF2F = $_takenF2F;
        $this->_familyMember = $_familyMember;
        $this->_relationship = $_relationship;
        $this->_diagnosis = $_diagnosis;
        $this->_whyHomefrontTeacher = $_whyHomefrontTeacher;
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
    public function getTakenF2F()
    {
        return $this->_takenF2F;
    }

    /**
     * @return mixed
     */
    public function getFamilyMember()
    {
        return $this->_familyMember;
    }

    /**
     * @return mixed
     */
    public function getRelationship()
    {
        return $this->_relationship;
    }

    /**
     * @return mixed
     */
    public function getDiagnosis()
    {
        return $this->_diagnosis;
    }

    /**
     * @return mixed
     */
    public function getWhyHomefrontTeacher()
    {
        return $this->_whyHomefrontTeacher;
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