<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\NotificationsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\NotificationsController Test Case
 *
 * @uses \App\Controller\NotificationsController
 */
class NotificationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Notifications',
        'app.Users',
        'app.Profiles',
        'app.Messages'
    ];

    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'category' => ['type' => 'string', 'length' => 50, 'null' => true],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false],
        'description' => ['type' => 'text', 'null' => true],
        'cta' => ['type' => 'text', 'null' => true],
        'seen' => ['type' => 'tinyint', 'default' => '0', 'null' => false],
        'created' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'user_id' => '1',
            'category' => 'First Notification Category',
            'title' => 'First Notification',
            'description' => 'First Notification Description',
            'cta' => 'First Notification Call to action',
            'seen' => '0',
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'user_id' => '1',
            'category' => 'Second Notification Category',
            'title' => 'Second Notification',
            'description' => 'Second Notification Description',
            'cta' => 'Second Notification Call to action',
            'seen' => '0',
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'user_id' => '1',
            'category' => 'Third Notification Category',
            'title' => 'Third Notification',
            'description' => 'Third Notification Description',
            'cta' => 'Third Notification Call to action',
            'seen' => '0',
            'created' => '2007-03-18 10:39:23'
        ]
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->login();
        $this->get('/notifications/index');
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
        $this->get('/notifications/view/1');
        $this->assertResponseCode(302);
    }

    public function testLivesync(): void
    {
        $this->login();
        $this->get('/notifications/livesync');
        $this->assertResponseOk();
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
        $this->post('/notifications/delete/1');
        $this->assertRedirectContains('/notifications');
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
