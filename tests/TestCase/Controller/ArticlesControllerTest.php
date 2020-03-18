<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ArticlesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\ArticlesController Test Case
 *
 * @uses \App\Controller\ArticlesController
 */
class ArticlesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Articles',
        'app.Users',
        'app.Profiles',
        'app.Notifications',
        'app.Messages'
    ];


    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false],
        'body' => 'text',
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'title' => 'First Article',
            'body' => 'First Article Body',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'title' => 'Second Article',
            'body' => 'Second Article Body',
            'created' => '2007-03-18 10:41:23',
            'modified' => '2007-03-18 10:43:31'
        ],
        [
            'title' => 'Third Article',
            'body' => 'Third Article Body',
            'created' => '2007-03-18 10:43:23',
            'modified' => '2007-03-18 10:45:31'
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
        $this->get('/articles/index');
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
        $this->get('/articles/view/1');
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
            'user_id' => '1',
            'title' => 'Fourth Article',
            'body' => 'Fourth Article Body'
        ];
        $this->post('/articles/add', $patchData);

        $this->assertRedirectContains('/articles');
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
            'user_id' => '1',
            'title' => 'Fourth Article updated',
            'body' => 'Fourth Article Body updated'
        ];
        $this->post('/articles/edit/1', $patchData);

        $this->assertRedirectContains('/articles');
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
        $this->post('/articles/delete/1');
        $this->assertRedirectContains('/articles');
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
