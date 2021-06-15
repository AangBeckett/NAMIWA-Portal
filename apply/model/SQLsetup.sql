/*
SQL STATEMENTS USED
use for DB setup
*/

/*
General application fields
status:   0 is denied,
          1 is submitted,
          2 is approved,
          3 is complete

category: 0 is archive,
          1 is active,
          2 is waitlist
*/
CREATE TABLE applicants
(
    applicant_id         INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    date_submitted       DATE               NOT NULL,
    app_status           INT                NOT NULL,
    category             INT                NOT NULL,
    app_type             INT                NOT NULL,
    fname                VARCHAR(60)        NOT NULL,
    pname                VARCHAR(60)                  DEFAULT 'N/A',
    lname                VARCHAR(70)        NOT NULL,
    pronouns             VARCHAR(50)        NOT NULL,
    birthdate            VARCHAR(10)        NOT NULL,
    NAMI_member          boolean            NOT NULL,
    affiliate            INT                NOT NULL,
    address              VARCHAR(70)        NOT NULL,
    city                 VARCHAR(70)        NOT NULL,
    address2             VARCHAR(70),
    state                VARCHAR(30)        NOT NULL,
    zip                  VARCHAR(12)        NOT NULL,
    primary_phone        VARCHAR(15)        NOT NULL,
    primary_time         VARCHAR(100)       NOT NULL,
    alternate_phone      VARCHAR(15),
    alternate_time       VARCHAR(100),
    email                VARCHAR(254)       NOT NULL,
    preference           VARCHAR(5)         NOT NULL,
    emergency_name       VARCHAR(120),
    emergency_phone      VARCHAR(15),
    special_needs        MEDIUMTEXT         NOT NULL,
    service_animal       MEDIUMTEXT         NOT NULL,
    mobility_need        MEDIUMTEXT         NOT NULL,
    need_rooming         VARCHAR(50)        NOT NULL,
    single_room          VARCHAR(50)        NOT NULL DEFAULT 'N/A',
    days_rooming         VARCHAR(200)                DEFAULT 'N/A',
    gender               VARCHAR(50)                 DEFAULT 'N/A',
    roommate_gender      VARCHAR(50)                 DEFAULT 'N/A',
    cpap_user            VARCHAR(10)                 DEFAULT false,
    roommate_cpap        VARCHAR(10)                 DEFAULT false,
    heard_about_training MEDIUMTEXT,
    other_classes        MEDIUMTEXT,
    certified            MEDIUMTEXT,
    notes                MEDIUMTEXT,
    affiliate_type       VARCHAR(50),
    member_expiration    VARCHAR(50),
    approver_name        VARCHAR(50),
    approver_title       VARCHAR(50),
    approval_date        VARCHAR(50),
    check_number         VARCHAR(50),
    info_id              INT                NOT NULL,
    other_affiliate_id   INT,
    FOREIGN KEY (app_type) references app_type (app_id),
    FOREIGN KEY (affiliate) references affiliates (affiliate_id),
    FOREIGN KEY (info_id) references app_type_info (info_id),
    FOREIGN KEY (other_affiliate_id) references other_affiliate (id)
);

CREATE TABLE other_affiliate
(
    affiliate_id   INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    affiliate_name varchar(100)       NOT NULL,
    leader_name	   varchar(100)       NOT NULL,
    leader_email   varchar(100)       NOT NULL,
    leader_phone   varchar(100)       NOT NULL
);


/* specific application tables */
CREATE TABLE FSG
(
    FSG_id          INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id    INT                NOT NULL,
    relative_mental MEDIUMTEXT,
    conviction      MEDIUMTEXT,
    why_want        MEDIUMTEXT,
    experience      MEDIUMTEXT,
    whom_co         MEDIUMTEXT,
    where_co        MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE P2P
(
    P2P_id            INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id      INT                NOT NULL,
    conviction        MEDIUMTEXT,
    why_want          MEDIUMTEXT,
    describe_recovery MEDIUMTEXT,
    give_back         MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE ETS
(
    ETS_id             INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id       INT                NOT NULL,
    conviction         MEDIUMTEXT,
    availability       MEDIUMTEXT,
    education          VARCHAR(200),
    experience         VARCHAR(200),
    languages          VARCHAR(200),
    age                VARCHAR(100),
    diagnosis          VARCHAR(200),
    self_disclosure    CHAR(10),
    positive_outlook   CHAR(10),
    background_check   CHAR(10),
    why_want           MEDIUMTEXT,
    mental_experience  MEDIUMTEXT,
    support_experience MEDIUMTEXT,
    recovery           MEDIUMTEXT,
    view_roles         MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE B
(
    B_id                INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id        INT                NOT NULL,
    conviction          MEDIUMTEXT,
    taken_basics        VARCHAR(5),
    taken_f2f           VARCHAR(5),
    parent              VARCHAR(5),
    child_age           INT(2),
    current_diagnosis   MEDIUMTEXT,
    length_of_illness   VARCHAR(200),
    educational_program VARCHAR(200),
    grad_date           VARCHAR(200),
    why_want            MEDIUMTEXT,
    child_experiences   MEDIUMTEXT,
    coteach_with        VARCHAR(200),
    teach_where         VARCHAR(200),
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE H
(
    H_id         INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id INT                NOT NULL,
    conviction   MEDIUMTEXT,
    relationship VARCHAR(20),
    diagnosis    VARCHAR(20),
    taken_f2f    VARCHAR(5),
    why_want     MEDIUMTEXT,
    coteach_with VARCHAR(200),
    teach_where  VARCHAR(200),
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE IOOV
(
    IOOV_id           INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id      INT                NOT NULL,
    conviction        MEDIUMTEXT,
    degree            VARCHAR(200),
    volunteer_exp     VARCHAR(200),
    diagnose          VARCHAR(200),
    diagnose_time     VARCHAR(200),
    current_diagnosis MEDIUMTEXT,
    hospitalized      VARCHAR(200),
    speaking_exp      VARCHAR(200),
    comfortable       INT,
    transportation    CHAR(10),
    not_present       MEDIUMTEXT,
    why_presenter     MEDIUMTEXT,
    time_recovered    MEDIUMTEXT,
    recovery          MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE PE
(
    PE_id                INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id         INT                NOT NULL,
    conviction           MEDIUMTEXT,
    availability         VARCHAR(200),
    degree               VARCHAR(200),
    volunteer_exp        VARCHAR(200),
    fluent_language      VARCHAR(200),
    describes            VARCHAR(200),
    young_adult          VARCHAR(100),
    current_diagnosis    VARCHAR(200),
    self_disclosure      CHAR(10),
    positive_outlook     CHAR(10),
    background_check     CHAR(10),
    why_want             MEDIUMTEXT,
    frontLine_experience MEDIUMTEXT,
    support_experience   MEDIUMTEXT,
    recovery             MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);

CREATE TABLE F2F
(
    F2F_id              INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id        INT                NOT NULL,
    conviction          MEDIUMTEXT,
    first_degree_family CHAR(10),
    relative            VARCHAR(200),
    diagnosis           VARCHAR(200),
    taken_f2f           VARCHAR(20),
    why_want            MEDIUMTEXT,
    coteach_with        VARCHAR(200),
    teach_where         VARCHAR(200),
    FOREIGN KEY (applicant_id) references applicants (applicant_id)

);

CREATE TABLE C
(
    C_id            INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    applicant_id    INT                NOT NULL,
    why_facilitator MEDIUMTEXT,
    experience      MEDIUMTEXT,
    description     MEDIUMTEXT,
    FOREIGN KEY (applicant_id) references applicants (applicant_id)
);


/*training questions tables*/

CREATE TABLE B_Qs
(
    id   INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2   MEDIUMTEXT,
    q2a  MEDIUMTEXT,
    q3   MEDIUMTEXT,
    q4   MEDIUMTEXT,
    q7   MEDIUMTEXT,
    q7a  MEDIUMTEXT,
    q7b  MEDIUMTEXT,
    q7c  MEDIUMTEXT,
    q7d  MEDIUMTEXT,
    q8   MEDIUMTEXT,
    q8a  MEDIUMTEXT,
    q9   MEDIUMTEXT,
    q9a  MEDIUMTEXT,
    q10  MEDIUMTEXT,
    q11  MEDIUMTEXT,
    q12  MEDIUMTEXT,
    q12a MEDIUMTEXT,
    q13  MEDIUMTEXT,
    q13a MEDIUMTEXT
);

CREATE TABLE C_Qs
(
    id     INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2     MEDIUMTEXT,
    q3     MEDIUMTEXT,
    q3note MEDIUMTEXT,
    q6     MEDIUMTEXT
);

CREATE TABLE ETS_Qs
(
    id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2  MEDIUMTEXT,
    q2a MEDIUMTEXT,
    q3  MEDIUMTEXT,
    q4  MEDIUMTEXT,
    q4a MEDIUMTEXT,
    q4b MEDIUMTEXT,
    q4c MEDIUMTEXT,
    q4d MEDIUMTEXT,
    q5  MEDIUMTEXT,
    q6  MEDIUMTEXT,
    q7  MEDIUMTEXT,
    q8  MEDIUMTEXT,
    q9  MEDIUMTEXT,
    q10 MEDIUMTEXT,
    q11 MEDIUMTEXT,
    q12 MEDIUMTEXT,
    q13 MEDIUMTEXT
);

CREATE TABLE F2F_Qs
(
    id     INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2     MEDIUMTEXT,
    q2a    MEDIUMTEXT,
    q3     MEDIUMTEXT,
    q3note MEDIUMTEXT,
    q3a    MEDIUMTEXT,
    q3b    MEDIUMTEXT,
    q4     MEDIUMTEXT,
    q4note MEDIUMTEXT,
    q7     MEDIUMTEXT,
    q8     MEDIUMTEXT,
    q8a    MEDIUMTEXT,
    q9     MEDIUMTEXT,
    q9a    MEDIUMTEXT
);

CREATE TABLE FSG_Qs
(
    id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q1  MEDIUMTEXT,
    q1a MEDIUMTEXT,
    q3  MEDIUMTEXT,
    q3a MEDIUMTEXT,
    q4  MEDIUMTEXT,
    q5  MEDIUMTEXT,
    q8  MEDIUMTEXT,
    q8a MEDIUMTEXT,
    q9  MEDIUMTEXT,
    q9a MEDIUMTEXT
);

CREATE TABLE H_Qs
(
    id     INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q1     MEDIUMTEXT,
    q1a    MEDIUMTEXT,
    q2     MEDIUMTEXT,
    q2note MEDIUMTEXT,
    q2a    MEDIUMTEXT,
    q2b    MEDIUMTEXT,
    q3     MEDIUMTEXT,
    q3note MEDIUMTEXT,
    q6     MEDIUMTEXT,
    q7     MEDIUMTEXT,
    q7a    MEDIUMTEXT,
    q8     MEDIUMTEXT,
    q8a    MEDIUMTEXT
);

CREATE TABLE IOOV_Qs
(
    id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2  MEDIUMTEXT,
    q2a MEDIUMTEXT,
    q5  MEDIUMTEXT,
    q5a MEDIUMTEXT,
    q5b MEDIUMTEXT,
    q5c MEDIUMTEXT,
    q5d MEDIUMTEXT,
    q5e MEDIUMTEXT,
    q5f MEDIUMTEXT,
    q5g MEDIUMTEXT,
    q6  MEDIUMTEXT,
    q6a MEDIUMTEXT,
    q7  MEDIUMTEXT,
    q8  MEDIUMTEXT,
    q9  MEDIUMTEXT,
    q10 MEDIUMTEXT,
    q11 MEDIUMTEXT
);

CREATE TABLE P2P_Qs
(
    id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2  MEDIUMTEXT,
    q2a MEDIUMTEXT,
    q4  MEDIUMTEXT,
    q5  MEDIUMTEXT,
    q6  MEDIUMTEXT
);

CREATE TABLE PE_Qs
(
    id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    q2  MEDIUMTEXT,
    q2a MEDIUMTEXT,
    q5  MEDIUMTEXT,
    q6  MEDIUMTEXT,
    q6a MEDIUMTEXT,
    q6b MEDIUMTEXT,
    q6c MEDIUMTEXT,
    q6d MEDIUMTEXT,
    q6e MEDIUMTEXT,
    q6f MEDIUMTEXT,
    q6g MEDIUMTEXT,
    q6h MEDIUMTEXT,
    q6i MEDIUMTEXT,
    q7  MEDIUMTEXT,
    q8  MEDIUMTEXT,
    q9  MEDIUMTEXT,
    q10 MEDIUMTEXT
);

/* application/training type tables */
CREATE TABLE app_type
(
    app_id   INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    app_type VARCHAR(100)       NOT NULL,
    ref_name VARCHAR(50)
);

-- active 1, inactive 0
CREATE TABLE app_type_info
(
    info_id  INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    date     VARCHAR(200),
    location VARCHAR(200),
    deadline VARCHAR(200),
    app_type INT,
    date2    VARCHAR(200),
    date3    VARCHAR(200),
    active   INT,
    FOREIGN KEY (app_type) references app_type (app_id)
);

/* affiliates table */
CREATE TABLE affiliates
(
    affiliate_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name         VARCHAR(200)       NOT NULL,
    email        VARCHAR(254)       NOT NULL
);

/* locations table*/
CREATE TABLE locations
(
    location_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    location    VARCHAR(200)       NOT NULL

);

/* admin portal user */
CREATE TABLE adminUser
(
    admin_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fname    VARCHAR(60)        NOT NULL,
    lname    VARCHAR(70)        NOT NULL,
    email    VARCHAR(254)       NOT NULL,
    password VARCHAR(255)       NOT NULL
);

/* setup basic data for tables */
INSERT INTO affiliates(name, email)
VALUES ('NAMI Chelan-Douglas', 'chelandouglasnami@gmail.com'),
       ('NAMI Clallam County', 'namiofclallamcounty@gmail.com'),
       ('NAMI Eastside', 'info@nami-eastside.org'),
       ('NAMI Jefferson County', 'namijeffco@yahoo.com'),
       ('NAMI Kitsap County', 'info@namikitsap.org'),
       ('NAMI Lewis County', 'namilewiscountywa@gmail.com'),
       ('NAMI Pierce County', 'info@namipierce.org'),
       ('NAMI Seattle', 'info@namiseattle.org'),
       ('NAMI Skagit', 'namiskagitpresident@gmail.com'),
       ('NAMI Snohomish County', 'nami.snohomish.county@gmail.com'),
       ('NAMI South King County', 'namiskc@qwestoffice.net'),
       ('NAMI Southwest Washington', 'info@namiswwa.org'),
       ('NAMI Spokane', 'programs@namispokane.org'),
       ('NAMI Thurston-Mason', 'info@namitm.org'),
       ('NAMI Tri-Cities', 'namitricities@gmail.com'),
       ('NAMI Walla Walla', 'namiwallaalla@gmail.com'),
       ('NAMI Washington Coast', 'president@nami-wacoast.org'),
       ('NAMI Whatcom', 'namiadmin@namiwhatcom.org'),
       ('NAMI Yakima', 'info@namiyakima.org'),
       ('Other', 'na@na.com');

INSERT INTO app_type(app_type, ref_name)
VALUES ('Family Support Group', 'familySupportGroup'),
       ('Peer-to-Peer', 'peer2peer'),
       ('Ending the Silence', 'endingTheSilence'),
       ('Connection', 'connection'),
       ('In Our Own Voice', 'inOurOwnVoice'),
       ('Provider Education', 'providerEducation'),
       ('Family-to-Family', 'family2family'),
       ('Homefront', 'homefront'),
       ('Basics', 'basics'),
       ('Smarts', 'smarts');

INSERT INTO locations(location)
VALUES ('Kirkland'),
       ('Olympia'),
       ('Redmond'),
       ('Spokane'),
       ('Yakima'),
       ('Online');