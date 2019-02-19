<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class ActiveMenuItemCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->see('Home', '.active');
        $I->click('About');
        $I->see('About', '.active');
        $I->click('Contact');
        $I->see('Contact', '.active');
        $I->click('Signup');
        $I->see('Signup', '.active');
        $I->click('Login');
        $I->see('Login', '.active');
    }
}
