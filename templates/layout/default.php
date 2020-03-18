<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php 
        if(isset($settings)) {
            echo $this->fetch('title') . ' | ' . $settings['backend_name'];
        } else {
            echo $this->fetch('website_title');
        }
        ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('theme.min.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?= $this->element('sidebar') ?>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <?= $this->element('topbar') ?>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Begin Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4" id="subHeader">
                        <h1 class="h3 mb-0 text-gray-800"><?= $this->fetch('header_title_top') ?></h1>
                        <div class="text-right d-none d-sm-block">
                            <?php
                            $buttons = $this->fetch('header_links');
                            $buttons = @unserialize($buttons);
                            if($buttons !== false) {
                                foreach($buttons as $button) {
                                    // check for PostLink 
                                    if(isset($button['link']['action']) && $button['link']['action'] == 'delete') {
                                        if(isset($authUser) && $authUser['role'] == 'admin') {
                                            $button['id'] = $button['link']['id'];
                                            $button['link'] = [
                                                'controller' => $button['link']['controller'],
                                                'action' => $button['link']['action'],
                                                $button['link']['id']
                                            ];
                                            echo $this->Form->postLink(
                                                '<i class="fas ' . $button['icon'] . ' fa-sm text-white-50"></i> ' . $button['title'],
                                                $button['link'],
                                                [
                                                    'confirm' => __('Are you sure you want to delete # {0}?', $button['id']),
                                                    'class' => 'd-inline-block btn btn-sm ' . $button['btn-class'] . ' shadow-sm ml-2',
                                                    'escape' => false
                                                ]
                                            );
                                        }
                                    } else {
                                        echo $this->Html->link(
                                            '<i class="fas ' . $button['icon'] . ' fa-sm text-white-50"></i> ' . $button['title'],
                                            $button['link'],
                                            [
                                                'escape' => false,
                                                'class' => 'd-inline-block btn btn-sm ' . $button['btn-class'] . ' shadow-sm ml-2'
                                            ]
                                        );
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <!-- End Page Heading -->

                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
                <!-- End Page Content -->
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; matibaski.ch 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
    
        </div>
        <!-- End of Content Wrapper -->
    
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= __('Ready to Leave?') ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?= __('Select "Logout" below if you are ready to end your current session.') ?></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <?= $this->Html->link(__('Logout'), [
                        'controller' => 'users',
                        'action' => 'logout'
                    ], [
                        'class' => 'btn btn-primary'
                    ]) ?>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" aria-live="polite" aria-atomic="true">
        <?= $this->Toast->render() ?>
        <?= $this->element('toasts') ?>
    </div>

    <?php //= $this->AssetCompress->script('theme'); ?>
    
    <script src="/plugins/jquery/jquery.min.js"></script> 
    <script src="/plugins/jqueryui/jquery-ui.min.js"></script>
    <script src="/plugins/popper.min.js"></script>
    <script src="/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/plugins/jquery-easing/jquery.easing.min.js"></script>
    <script src="/plugins/jquery-timeago/jquery.timeago.js"></script>
    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script src="/plugins/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js"></script>
    <script src="/js/main.js"></script>
    <?php
    if($this->fetch('load_scripts')) {
        $scripts = unserialize($this->fetch('load_scripts'));
        foreach($scripts as $script) {
            echo "\t" . '<script src="' . $script . '"></script>' . "\n";
        }
    }
    ?>
    <script src="/js/theme.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>