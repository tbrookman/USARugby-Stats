<?php

/**
 * Step definitions for Gherkin scenarios.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext
{
    public function __construct()
    {
        // Sub-contexts allow us to mixin different commands, this is a stop-gap
        // till we move to PHP 5.4 and use traits.  For example:
        // $this->useContext('mink', new Behat\MinkExtension\Context\MinkContext);
        //
        // Then we can access the Subcontext via a helper method, for example:
        // $this->getSubcontext('mink')->getSession()->wait(5000, "$('.suggestions-results').children().length > 0");
    }
}
