<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
        'app.Profiles',
        'app.Notifications',
        'app.Messages'
    ];

    public $fields = [
        'id' => ['type' => 'integer'],
        'username' => ['type' => 'string', 'length' => 50, 'null' => false],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false],
        'role' => ['type' => 'string', 'length' => 20, 'null' => true],
        'active' => ['type' => 'tinyint', 'default' => '0', 'null' => false],
        'activation_hash' => ['type' => 'string', 'length' => 255, 'null' => true],
        'disabled' => ['type' => 'tinyint', 'default' => '0', 'null' => false],
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'username' => 'first@user.com',
            'password' => 'first_password',
            'role' => 'first_role',
            'active' => '1',
            'activation_hash' => null,
            'disabled' => '0',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'username' => 'second@user.com',
            'password' => 'second_password',
            'role' => 'second_role',
            'active' => '0',
            'activation_hash' => 'gjnw39uhfhsdfh235423rsdf',
            'disabled' => '0',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'username' => 'third@user.com',
            'password' => 'third_password',
            'role' => 'third_role',
            'active' => '1',
            'activation_hash' => null,
            'disabled' => '0',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->login();
        $this->get('/users/index');
        $this->assertResponseCode(302);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->login();
        $this->get('/users/view/1');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->login();
        $patchData = [
            'username' => 'new@user.com',
            'password' => 'my_password',
            'password_confirm' => 'my_password',
            'role' => 'my_role',
            'active' => '0',
            'activation_hash' => 'gjnw39uhfhsdfh235423rsdf',
            'disabled' => '0',
            'profile' => [
                'first_name' => 'Test',
                'last_name' => 'User'
            ]
        ];
        $this->post('/users/add', $patchData);

        $this->assertRedirectContains('/users');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->login();
        $patchData = [
            'username' => 'new@user.com',
            'password' => 'my_password',
            'password_confirm' => 'my_password',
            'role' => 'my_role',
            'active' => '0',
            'activation_hash' => 'gjnw39uhfhsdfh235423rsdf',
            'disabled' => '0',
            'profile' => [
                'first_name' => 'Test',
                'last_name' => 'User'
            ]
        ];
        $this->post('/users/edit/1', $patchData);

        $this->assertRedirectContains('/users');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->login();
        $this->post('/users/delete/1');
        $this->assertResponseCode(302);
    }

    /**
     * login method
     * @param  integer $userId
     * @return void
     */
    protected function login($userId = 1)
    {
        $users = TableRegistry::get('Users');
        $user = $users->get($userId);
        $this->session(['Auth' => $user]);
    }
}
