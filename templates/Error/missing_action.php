<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Core\Plugin;


$headerLinks = [];
$this->assign('header_title_top', '');
$this->assign('header_links', serialize($headerLinks));
$this->assign('website_title', '404 Error');
?>

<div class="text-center">
	<div class="error mx-auto" data-text="404">404</div>
	<p class="lead text-gray-800 mb-5"><?= __('Page Not Found') ?></p>
	<p class="text-gray-500 mb-0"><?= __('It looks like you found a glitch in the matrix...') ?></p>
	<a href="/">&larr; <?= __('Back to Dashboard') ?></a>
</div>

<?php
$namespace = Configure::read('App.namespace');
if (!empty($plugin)) {
    $namespace = str_replace('/', '\\', $plugin);
}
$prefixNs = '';
$prefix = isset($prefix) ? $prefix : '';
if (!empty($prefix)) {
    $prefix = array_map('Cake\Utility\Inflector::camelize', explode('/', $prefix));
    $prefixNs = '\\' . implode('\\', $prefix);
    $prefix = implode(DIRECTORY_SEPARATOR, $prefix) . DIRECTORY_SEPARATOR;
}

// Controller MissingAction support
if (isset($controller)) {
    $baseClass = $namespace . '\Controller\AppController';
    $extends = 'AppController';
    $type = 'Controller';
    $class = Inflector::camelize($controller);
}
// Mailer MissingActionException support
if (isset($mailer)) {
    $baseClass = 'Cake\Mailer\Mailer';
    $type = $extends = 'Mailer';
    $class = Inflector::camelize($mailer);
}

if (empty($plugin)) {
    $path = APP_DIR . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $prefix . h($class) . '.php' ;
} else {
    $path = Plugin::classPath($plugin) . $type . DIRECTORY_SEPARATOR . $prefix . h($class) . '.php';
}

$this->layout = 'error';

$this->assign('title', sprintf('Missing Method in %s', h($class)));
$this->assign(
    'subheading',
    sprintf('<strong>Error:</strong> The action <em>%s</em> is not defined in <em>%s</em>', h($action), h($class))
);
$this->assign('templateName', 'missing_action.php');

$this->start('file');
?>
<p class="error">
    <strong>Solution:</strong>
    <?= sprintf('Create <em>%s::%s()</em> in file: %s.', h($class),  h($action), $path); ?>
</p>

<?php
$code = <<<PHP
<?php
namespace {$namespace}\\{$type}{$prefixNs};

use {$baseClass};

class {$class} extends {$extends}
{

    public function {$action}()
    {

    }
}
PHP;
?>

<div class="code-dump"><?php highlight_string($code) ?></div>
<?php $this->end() ?>
