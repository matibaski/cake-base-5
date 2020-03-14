<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$headerLinks = [];
$this->assign('header_title_top', '');
$this->assign('header_links', serialize($headerLinks));
$this->assign('website_title', '500 Error');

$this->layout = 'error';
?>

<div class="text-center">
	<div class="error mx-auto" data-text="500">500</div>
	<p class="lead text-gray-800 mb-5"><?= __('Server Error') ?></p>
	<p class="text-gray-500 mb-0"><?= __('It looks like you found a glitch in the matrix...') ?></p>
	<a href="/">&larr; <?= __('Back to Dashboard') ?></a>
</div>

<?php
if (Configure::read('debug')) :
    //$this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.php');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php

$this->end();
endif;
?>

<?= $this->fetch('file') ?>