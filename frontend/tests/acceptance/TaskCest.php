<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class TaskCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function login(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->click('Login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', '123456');
        $I->click('login-button');
        $I->wait(1);
    }

    /**
     * @depends login
     */
    public function taskList(AcceptanceTester $I)
    {
        $I->see('Logout');
        $I->click('Tasks');
    }

    /**
     * @depends taskList
     */
    public function taskCreate(AcceptanceTester $I)
    {
        $I->see('Logout');
        $I->click('Tasks');
        $I->click(['name' =>'task-create']);
        $I->fillField('TaskForm[name]', 'test task');
        $I->fillField('TaskForm[deadline]', date('M d, Y', strtotime('+7 day')));
        $I->click('Save');
        $I->wait(1);
        $I->see('Task created successfully');
        $I->wait(1);
    }


    /**
     * @depends taskCreate
     */
    public function taskUpdate(AcceptanceTester $I)
    {

        $I->click('Tasks');
        $I->click('test task');
        $I->fillField('TaskForm[name]', 'update test task');
        $I->fillField('TaskForm[deadline]', date('M d, Y', strtotime('+5 day')));
        $I->click('Save');
        $I->wait(1);
        $I->see('Task updated successfully');
        $I->wait(1);
    }

    /**
     * @depends taskUpdate
     */
    public function taskDelete(AcceptanceTester $I)
    {
        $I->click('Tasks');
        $I->click('update test task');
        $I->click('Delete');
        $I->wait(1);
        $I->see('Task deleted successfully');
    }

}
