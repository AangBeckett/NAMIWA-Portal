<?php

/**
 * Class OtherAffiliate stores the contact information for non-Washington NAMI Affiliates
 * @author Olivia Ringhiser
 * @version 12/17/20
 */
class OtherAffiliate
{
    private $_affiliateName;
    private $_leaderName;
    private $_leaderEmail;
    private $_leaderPhone;

    /**
     * OtherAffiliate constructor.
     * @param $_affiliateName
     * @param $_leaderName
     * @param $_leaderEmail
     * @param $_leaderPhone
     */
    public function __construct($_affiliateName, $_leaderName, $_leaderEmail, $_leaderPhone)
    {
        $this->_affiliateName = $_affiliateName;
        $this->_leaderName = $_leaderName;
        $this->_leaderEmail = $_leaderEmail;
        $this->_leaderPhone = $_leaderPhone;
    }

    /**
     * The name of the non-Washington State affiliate the applicant belongs to
     * @return mixed the other affiliate's name
     */
    public function getAffiliateName()
    {
        return $this->_affiliateName;
    }

    /**
     * The name of the leader of the other NAMI affiliate
     * @return mixed the leader's name
     */
    public function getLeaderName()
    {
        return $this->_leaderName;
    }

    /**
     * The email address to contact the affiliate leader at
     * @return mixed the leader's email address
     */
    public function getLeaderEmail()
    {
        return $this->_leaderEmail;
    }

    /**
     * The phone number to contact the affiliate leader at
     * @return mixed the leader's phone number
     */
    public function getLeaderPhone()
    {
        return $this->_leaderPhone;
    }


}