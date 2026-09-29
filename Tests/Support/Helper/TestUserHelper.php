<?php

namespace Support\Helper;

use Codeception\Module;
use Codeception\TestInterface;

class TestUserHelper extends Module
{
  private static array $users = [];

  public function _before(TestInterface $test){
    return $this->createUser();
  }

  /**
   * @param string $login
   * @param string $password
   * @return array
   */
  private function createUser(string $login = 'api_user', string $password = 'api_pass'): array
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $testUser = [
      'id' => random_int(10000, 99999),
      'login' => $login,
      'password_hash' => $hashedPassword,
      'created_at' => date('Y-m-d H:i:s'),
      'is_active' => true,
    ];

    self::$users[$testUser['id']] = $testUser;

    return $testUser;
  }

  /**
   * @param string $login
   */
  public function findByLogin(string $login): ?array
  {
    foreach (self::$users as $user) {
      if ($user['login'] === $login) {
        return $user;
      }
    }
    return null;
  }
}
