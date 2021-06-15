<?php

/**
 * @author Imelda Medina
 * @version 1.0
 * Class CLongAnswers
 */

class CLongAnswers
{
    private $_whyFacilitator;
    private $_experience;
    private $_description;

    /**
     * CLongAnswers constructor.
     * @param $_whyFacilitator
     * @param $_experience
     * @param $_description
     */
    public function __construct($_whyFacilitator, $_experience, $_description)
    {
        $this->_whyFacilitator = $_whyFacilitator;
        $this->_experience = $_experience;
        $this->_description = $_description;
    }

    /**
     * Getter to get why the volunteer
     * wants to be a facilitator
     * @return mixed
     */
    public function getWhyFacilitator()
    {
        return $this->_whyFacilitator;
    }

    /**
     * Getter to get volunteer experience
     * @return mixed
     */
    public function getExperience()
    {
        return $this->_experience;
    }

    /**
     * Getter to get description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }
}