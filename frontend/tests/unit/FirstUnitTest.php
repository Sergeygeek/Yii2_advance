<?php namespace frontend\tests;

use frontend\models\ContactForm;

class FirstUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSimple()
    {
        // check if true
        $bool = true;
        $this->assertTrue($bool, 'is true');
        // check if equals
        $num = 5;
        $this->assertEquals(5, $num, 'is equal');
        // check if less
        $this->assertLessThan(6, $num, 'is less');
        // check if the attribute value equals
        $name = 'Sergey';
        $contactForm = new ContactForm([
            'name' => $name,
            'email' => 'serj12@mail.ru',
            ]);

        $this->assertAttributeEquals($name, 'name', $contactForm);
        // check if array has key
        $arr = ['name' => 'Sergey', 'email' => 'serj12@mail.ru'];
        $this->assertArrayHasKey('name', $arr);

    }
}