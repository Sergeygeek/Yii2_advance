<?php namespace frontend\tests\functional;
use Codeception\Codecept;
use Codeception\Example;
use frontend\tests\FunctionalTester;
use yii\helpers\VarDumper;

class ActiveMenuItemCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $pages)
    {
        $I->amOnPage($pages['url']);
        $I->see($pages['link'], '.active');
    }

    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['url'=>"site/index", 'title'=>"My Yii Application", 'link'=>"Home"],
            ['url'=>"site/about", 'title'=>"About", 'link'=>"About"],
            ['url'=>"site/contact", 'title'=>"Contact", 'link'=>"Contact"],
            ['url'=>"site/signup", 'title'=>"Signup", 'link'=>"Signup"],
            ['url'=>"site/login", 'title'=>"Login", 'link'=>"Login"],
        ];
    }
}
