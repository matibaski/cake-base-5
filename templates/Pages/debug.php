<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;
?>
<div class="card p-4">
    <header class="mt-4">
        <div class="text-center">
            <a href="https://cakephp.org/" target="_blank">
                <img alt="CakePHP" src="https://cakephp.org/v2/img/logos/CakePHP_Logo.svg" width="350" />
            </a>
            <h1 class="mt-4">
                Welcome to CakePHP <?php echo Configure::version() ?> Strawberry
            </h1>
        </div>
    </header>
    <main class="main">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="message default text-center">
                        <small>Please be aware that this page will not be shown if you turn off debug mode unless you replace templates/Pages/home.php with your own version.</small>
                    </div>
                    <?php Debugger::checkSecurityKeys(); ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6">
                    <h4>Environment</h4>
                    <ul>
                    <?php if (version_compare(PHP_VERSION, '7.2.0', '>=')) : ?>
                        <li class="bullet success">Your version of PHP is 7.2.0 or higher (detected <?php echo PHP_VERSION ?>).</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP is too low. You need PHP 7.2.0 or higher to use CakePHP (detected <?php echo PHP_VERSION ?>).</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('mbstring')) : ?>
                        <li class="bullet success">Your version of PHP has the mbstring extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the mbstring extension loaded.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('openssl')) : ?>
                        <li class="bullet success">Your version of PHP has the openssl extension loaded.</li>
                    <?php elseif (extension_loaded('mcrypt')) : ?>
                        <li class="bullet success">Your version of PHP has the mcrypt extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the openssl or mcrypt extension loaded.</li>
                    <?php endif; ?>

                    <?php if (extension_loaded('intl')) : ?>
                        <li class="bullet success">Your version of PHP has the intl extension loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your version of PHP does NOT have the intl extension loaded.</li>
                    <?php endif; ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <h4>Filesystem</h4>
                    <ul>
                    <?php if (is_writable(TMP)) : ?>
                        <li class="bullet success">Your tmp directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your tmp directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php if (is_writable(LOGS)) : ?>
                        <li class="bullet success">Your logs directory is writable.</li>
                    <?php else : ?>
                        <li class="bullet problem">Your logs directory is NOT writable.</li>
                    <?php endif; ?>

                    <?php $settings = Cache::getConfig('_cake_core_'); ?>
                    <?php if (!empty($settings)) : ?>
                        <li class="bullet success">The <em><?php echo $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</li>
                    <?php else : ?>
                        <li class="bullet problem">Your cache is NOT working. Please check the settings in config/app.php</li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-sm-6">
                    <h4>Database</h4>
                    <?php
                    try {
                        $connection = ConnectionManager::get('default');
                        $connected = $connection->connect();
                    } catch (Exception $connectionError) {
                        $connected = false;
                        $errorMsg = $connectionError->getMessage();
                        if (method_exists($connectionError, 'getAttributes')) :
                            $attributes = $connectionError->getAttributes();
                            if (isset($errorMsg['message'])) :
                                $errorMsg .= '<br />' . $attributes['message'];
                            endif;
                        endif;
                    }
                    ?>
                    <ul>
                    <?php if ($connected) : ?>
                        <li class="bullet success">CakePHP is able to connect to the database.</li>
                    <?php else : ?>
                        <li class="bullet problem">CakePHP is NOT able to connect to the database.<br /><?php echo $errorMsg ?></li>
                    <?php endif; ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <h4>DebugKit</h4>
                    <ul>
                    <?php if (Plugin::isLoaded('DebugKit')) : ?>
                        <li class="bullet success">DebugKit is loaded.</li>
                    <?php else : ?>
                        <li class="bullet problem">DebugKit is NOT loaded. You need to either install pdo_sqlite, or define the "debug_kit" connection name.</li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12 links">
                    <h3>Getting Started</h3>
                    <a target="_blank" href="https://book.cakephp.org/4/en/">CakePHP Documentation</a>
                    <a target="_blank" href="https://book.cakephp.org/4/en/tutorials-and-examples/cms/installation.html">The 20 min CMS Tutorial</a>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12 links">
                    <h3>Help and Bug Reports</h3>
                    <a target="_blank" href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
                    <a target="_blank" href="http://cakesf.herokuapp.com/">Slack</a>
                    <a target="_blank" href="https://github.com/cakephp/cakephp/issues">CakePHP Issues</a>
                    <a target="_blank" href="http://discourse.cakephp.org/">CakePHP Forum</a>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12 links">
                    <h3>Docs and Downloads</h3>
                    <a target="_blank" href="https://api.cakephp.org/">CakePHP API</a>
                    <a target="_blank" href="https://bakery.cakephp.org">The Bakery</a>
                    <a target="_blank" href="https://book.cakephp.org/4/en/">CakePHP Documentation</a>
                    <a target="_blank" href="https://plugins.cakephp.org">CakePHP plugins repo</a>
                    <a target="_blank" href="https://github.com/cakephp/">CakePHP Code</a>
                    <a target="_blank" href="https://github.com/FriendsOfCake/awesome-cakephp">CakePHP Awesome List</a>
                    <a target="_blank" href="https://www.cakephp.org">CakePHP</a>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12 links">
                    <h3>Training and Certification</h3>
                    <a target="_blank" href="https://cakefoundation.org/">Cake Software Foundation</a>
                    <a target="_blank" href="https://training.cakephp.org/">CakePHP Training</a>
                </div>
            </div>
        </div>
    </main>
</div>