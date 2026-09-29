<?php

namespace Support\Helper;

use Codeception\Module;
use Codeception\Module\REST;

class TestApiHelper extends Module
{
  /**
   * @param REST $I
   * @return void
   * @throws \Exception
   */
  public function createUserViaApi(REST $I): void
  {
    $I->amHttpAuthenticated('api_user', 'api_secret');

    $I->haveHttpHeader('Content-Type', 'application/json');

    $I->sendPost('/api/v1/users', [
      'username' => 'new_user_' . time(),
      'email' => 'new_user_' . time() . '@example.com',
      'password' => 'SecurePass123!',
      'role' => 'user',
    ]);

    $I->seeResponseCodeIs(201); // Created
    $I->seeResponseContainsJson([
      'status' => 'success',
    ]);

    $I->seeResponseMatchesJsonType([
      'id' => 'integer',
      'username' => 'string',
      'email' => 'string',
      'created_at' => 'string',
    ]);

    $userId = $I->grabDataFromResponseByJsonPath('$.id')[0];
    $I->assertNotEmpty($userId);
  }
}