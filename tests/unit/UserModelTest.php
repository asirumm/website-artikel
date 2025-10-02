<?php
namespace Test\unit;

use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public function testInsert()
    {
        $userModel = new UserModel();

        $data =  [
            'user_id'=>bin2hex(random_bytes(9)),
            'email'=>'target@gmail.com',
            'username'=>'example',
            'password'=>'example',
            'role'=>'ADMIN'
        ];

        $result = $userModel->insert($data);

        self::assertNotFalse($result);
    }
}
