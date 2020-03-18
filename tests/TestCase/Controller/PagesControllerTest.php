<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Application;
use Cake\ORM\TableRegistry;

/**
 * PagesControllerTest class
 *
 * @uses \App\Controller\PagesController
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $fixtures = [
        'app.Articles',
        'app.Users',
        'app.Profiles',
        'app.Notifications',
        'app.Messages'
    ];

    /**
     * testMultipleGet method
     *
     * @return void
     */
    public function testMultipleGet()
    {
        $this->login();
        $this->get('/pages/origin');
        $this->assertResponseOk();
        $this->get('/pages/origin');
        $this->assertResponseOk();
    }

    /**
     * testDisplay method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->login();
        $this->get('/pages/origin');
        $this->assertResponseOk();
        $this->assertResponseContains('CakePHP');
        $this->assertResponseContains('<html>');
    }

    /**
     * Test that missing template renders 404 page in production
     *
     * @return void
     */
    // public function testMissingTemplate()
    // {
    //     $this->login();
    //     Configure::write('debug', false);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseError();
    //     $this->assertResponseContains('Error');
    // }

    /**
     * Test that missing template in debug mode renders missing_template error page
     *
     * @return void
     */
    // public function testMissingTemplateInDebug()
    // {
    //     $this->login();
    //     Configure::write('debug', false);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseError();
    //     $this->assertResponseContains('Error');
        
    //     Configure::write('debug', true);
    //     $this->get('/pages/not_existing');

    //     $this->assertResponseFailure();
    //     $this->assertResponseContains('Missing Template');
    //     $this->assertResponseContains('Stacktrace');
    //     $this->assertResponseContains('not_existing.php');
        
    // }

    /**
     * Test directory traversal protection
     *
     * @return void
     */
    // public function testDirectoryTraversalProtection()
    // {
    //     $this->login();
    //     $this->get('/pages/../Layout/ajax');
    //     $this->assertResponseCode(403);
    //     $this->assertResponseContains('Forbidden');
    // }

    /**
     * Test that CSRF protection is applied to page rendering.
     *
     * @reutrn void
     */
    // public function testCsrfAppliedError()
    // {
    //     $this->login();
    //     $this->post('/pages/origin', ['hello' => 'world']);

    //     $this->assertResponseCode(403);
    //     $this->assertResponseContains('CSRF');
    // }

    /**
     * Test that CSRF protection is applied to page rendering.
     *
     * @reutrn void
     */
    // public function testCsrfAppliedOk()
    // {
    //     $this->enableCsrfToken();
    //     $this->enableSecurityToken();
    //     $this->login();
    //     $this->post('/pages/origin', ['hello' => 'world']);

    //     $this->assertResponseCode(200);
    //     $this->assertResponseContains('CakePHP');
    // }

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
