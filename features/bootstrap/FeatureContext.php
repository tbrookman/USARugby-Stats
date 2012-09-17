<?php

use Source\DataSource;
/**
 * Step definitions for Gherkin scenarios.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext
{

    static private $email = NULL;

    public function __construct()
    {
        // Sub-contexts allow us to mixin different commands, this is a stop-gap
        // till we move to PHP 5.4 and use traits.  For example:
        // $this->useContext('mink', new Behat\MinkExtension\Context\MinkContext);
        //
        // Then we can access the Subcontext via a helper method, for example:
        // $this->getSubcontext('mink')->getSession()->wait(5000, "$('.suggestions-results').children().length > 0");
    }

    /**
     * @BeforeSuite
     */
    public static function prepare() {
        $rand = (isset($rand) && !empty($rand)) ? $rand : rand();
        self::$email = "usa.rugby.$rand@example.com";
        $db = new Source\DataSource;
        $user_info = array(
            'login' => self::$email,
            'team' => 0,
            'access' => 1,
            'uuid' => NULL,
        );
        $db->addUser($user_info);
    }

    /**
     * @AfterSuite
     */
    public static function cleanDataBase() {
        $db = new Source\DataSource;
        $users[0]['email'] = self::$email;
        $db->removeUsers($users);
    }

    /**
     * @When /^I get rand email and fill in "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function iGetRandEmailAndFillIn($field)
    {
        $field = $this->fixStepArgument($field);
        $this->getSession()->getPage()->fillField($field, self::$email);
    }

    /**
     * Solves Captcha on AllPlayers.com and fills in form field.
     * @When /^I solve captcha and fill in "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function iSolveCaptchaAndFillIn($field)
    {
        $field = $this->fixStepArgument($field);
        $captcha = $this->getSession()->getPage()->find('css', 'div#edit-captcha-response-wrapper span.field-prefix')->getText();
        list($number_1, $number_2, $equals) = preg_split('/[+\=]/', $captcha);
        $solution = (int) $number_1 + (int) $number_2;
        $this->getSession()->getPage()->fillField($field, $solution);
    }

}
