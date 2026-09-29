<?php

namespace Tests\Acceptance;

use Support\AcceptanceTester;

class LoginCest
{
  private const LOGIN_FIELD = 'input[name="LoginForm[email]"]';
  private const PASSWORD_FIELD = 'input[name="LoginForm[password]"]';
  private const SUBMIT_BUTTON = 'button[type="submit"]';
  private const FORGOT_LINK = 'a[href*="restore"]';
  private const ERROR_MESSAGE = 'p.help-block-error';

  public function _before(AcceptanceTester $I): void
  {
    $I->amOnPage('/');
  }

  public function wrongFields(AcceptanceTester $I): void
  {
    $I->wantTo('Вход с невалидными логином/паролем');
    $I->fillField(self::LOGIN_FIELD, 'asdasd@asasd.ru');
    $I->fillField(self::PASSWORD_FIELD, 'szdasdad');
    $I->click(self::SUBMIT_BUTTON);
    $I->wait(1);
    $I->see('Некорректный email / пароль');
  }

  public function emptyFields(AcceptanceTester $I): void
  {
    $I->wantTo('Проверить отправку пустой формы');
    $I->fillField(self::LOGIN_FIELD, '');
    $I->fillField(self::PASSWORD_FIELD, '');
    $I->click(self::SUBMIT_BUTTON);
    $I->wait(1);
    $I->seeElement(self::ERROR_MESSAGE);
  }

  public function passwordMasking(AcceptanceTester $I): void
  {
    $I->wantTo('Проверить, что пароль маскируется');
    $I->seeElement(self::PASSWORD_FIELD.'[type=password]');
  }

  public function forgotPasswordLink(AcceptanceTester $I): void
  {
    $I->wantTo('Проверить переход по ссылке восстановления пароля');
    $I->click(self::FORGOT_LINK);
    $I->seeInCurrentUrl('restore-password');
    $I->seeElement('form');
  }
}