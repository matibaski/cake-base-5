<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MessagesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MessagesController Test Case
 *
 * @uses \App\Controller\MessagesController
 */
class MessagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Messages',
        'app.Users',
        'app.Profiles',
        'app.Notifications'
    ];

    public $fields = [
        'id' => ['type' => 'integer'],
        'to_user_id' => ['type' => 'integer'],
        'from_user_id' => ['type' => 'integer'],
        'message' => ['type' => 'text', 'null' => true],
        'seen' => ['type' => 'tinyint', 'default' => '0', 'null' => false],
        'created' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'to_user_id' => '1',
            'to_user_id' => '2',
            'message' => 'First Message',
            'seen' => '0',
            'created' => '2007-03-18 10:41:23',
            'modified' => '2007-03-18 10:43:31'
        ],
        [
            'to_user_id' => '1',
            'to_user_id' => '2',
            'message' => 'Second Message',
            'seen' => '0',
            'created' => '2007-03-18 10:41:23',
            'modified' => '2007-03-18 10:43:31'
        ],
        [
            'to_user_id' => '1',
            'to_user_id' => '2',
            'message' => 'Third Message',
            'seen' => '0',
            'created' => '2007-03-18 10:41:23',
            'modified' => '2007-03-18 10:43:31'
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
        $this->get('/messages/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->login();
        $this->get('/messages/view/1');
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
            'to_user_id' => '1',
            'from_user_id' => '2',
            'message' => 'Fourth Message'
        ];
        $this->post('/messages/add', $patchData);

        $this->assertRedirectContains('/messages');
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
        $this->post('/messages/delete/1');
        $this->assertRedirectContains('/messages');
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
