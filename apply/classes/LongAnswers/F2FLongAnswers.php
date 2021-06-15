<?php

/**
 * Class for Family-To-Family training long answers
 * @author Maureen Kariuki
 * @version 06/14/2020
 */
class F2FLongAnswers
{
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
    public function getFirstDegreeFamily()
    {
        return $this->_firstDegreeFamily;
    }

    /**
     * @return mixed
     */
    public function getRelative()
    {
        return $this->_relative;
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
    public function getTakenF2F()
    {
        return $this->_takenF2F;
    }

    /**
     * @return mixed
     */
    public function getWhyF2FTeacher()
    {
        return $this->_whyF2FTeacher;
    }

    /**
     * @return mixed
     */
    public function getCoTeach()
    {
        return $this->_coTeach;
    }

    /**
     * @return mixed
     */
    public function getCoTeachWith()
    {
        return $this->_coTeachWith;
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

    private $_convict;
    private $_convictText;
    private $_firstDegreeFamily;
    private $_relative;
    private $_diagnosis;
    private $_takenF2F;
    private $_whyF2FTeacher;
    private $_coTeach;
    private $_coTeachWith;
    private $_knowWhere;
    private $_teachWhere;


    /**
     * F2FLongAnswers constructor.
     * @param $_convict
     * @param $_convictText
     * @param $_firstDegreeFamily
     * @param $_relative
     * @param $_diagnosis
     * @param $_takenF2F
     * @param $_whyF2FTeacher
     * @param $_coTeach
     * @param $_coTeachWith
     * @param $_knowWhere
     * @param $_teachWhere
     */
    public function __construct($_convict, $_convictText, $_firstDegreeFamily, $_relative, $_diagnosis, $_takenF2F, $_whyF2FTeacher,
                                $_coTeach, $_coTeachWith, $_knowWhere, $_teachWhere)
    {

        $this->_convict = $_convict;
        $this->_convictText = $_convictText;
        $this->_firstDegreeFamily = $_firstDegreeFamily;
        $this->_relative = $_relative;
        $this->_diagnosis = $_diagnosis;
        $this->_takenF2F = $_takenF2F;
        $this->_whyF2FTeacher = $_whyF2FTeacher;
        $this->_coTeach = $_coTeach;
        $this->_coTeachWith = $_coTeachWith;
        $this->_knowWhere = $_knowWhere;
        $this->_teachWhere = $_teachWhere;
    }


}