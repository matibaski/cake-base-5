<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\NavigationsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\NavigationsController Test Case
 *
 * @uses \App\Controller\NavigationsController
 */
class NavigationsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Navigations',
        'app.Users',
        'app.Profiles',
        'app.Notifications',
        'app.Messages'
    ];

    public $fields = [
        'id' => ['type' => 'integer'],
        'icon' => ['type' => 'string', 'length' => 50, 'null' => true],
        'title' => ['type' => 'string', 'length' => 50, 'null' => true],
        'link' => ['type' => 'text', 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'icon' => 'First Navigation Icon',
            'title' => 'First Navigation',
            'link' => 'First Navigation Link'
        ],
        [
            'icon' => 'Second Navigation Icon',
            'title' => 'Second Navigation',
            'link' => 'Second Navigation Link'
        ],
        [
            'icon' => 'Third Navigation Icon',
            'title' => 'Third Navigation',
            'link' => 'Third Navigation Link'
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
        $this->get('/navigations/index');
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
            'link_type' => 'url',
            'icon' => 'Fourth Navigation Icon',
            'title' => 'Fourth Navigation',
            'link' => [
                'url' => 'My URL',
                'controller' => 'my_controller',
                'action' => 'my_action',
                'pass0' => 'my_pass0',
                'pass1' => 'my_pass1'
            ]
        ];
        $this->post('/navigations/add', $patchData);

        $this->assertRedirectContains('/navigations');
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
            'link_type' => 'url',
            'icon' => 'Fourth Navigation Icon',
            'title' => 'Fourth Navigation',
            'link' => [
                'url' => 'My URL',
                'controller' => 'my_controller',
                'action' => 'my_action',
                'pass0' => 'my_pass0',
                'pass1' => 'my_pass1'
            ]
        ];
        $this->post('/navigations/edit/1', $patchData);

        $this->assertRedirectContains('/navigations');
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
        $this->post('/navigations/delete/1');
        $this->assertRedirectContains('/navigations');
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
