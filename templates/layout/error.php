<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php
        if(isset($settings)) {
            echo $this->fetch('website_title') . ' | ' . $settings['backend_name'];
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

        <?= $this->element('sidebar', compact('nav')) ?>
        
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= ($debug && $authUser['role'] == 'admin') ? $this->fetch('title') : ''; ?></h1>
                    </div>
                    <!-- End Page Heading -->
                    <?= $this->Flash->render() ?>
                    <?= (!$debug || $authUser['role'] != 'admin') ? $this->fetch('content') : '' ; ?>

                    <?php if($debug && $authUser['role'] == 'admin'): ?>
                        <div class="error-section">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Stack Trace</h5>
                                    <div class="card p-3 mb-3">
                                        <?= $this->element('exception_stack_trace_nav') ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5>Errorcode</h5>
                                    <div class="error-inner">
                                        <?php if ($this->fetch('subheading')): ?>
                                            <p class="error-subheading">
                                            <?= $this->fetch('subheading') ?>
                                            </p>
                                        <?php endif; ?>

                                        <?= $this->element('exception_stack_trace'); ?>

                                        <div class="error-suggestion">
                                            <?= (!empty($this->fetch('file'))) ? $this->fetch('file') : '<i>No suggestion available.</i>' ; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
    <?= $this->element('toasts') ?>

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
            echo '<script src="' . $script . '"></script>' . "\n";
        }
    }
    ?>
    <script src="/js/theme.js"></script>
    <?= $this->fetch('script') ?>

    <script type="text/javascript">
        function bindEvent(selector, eventName, listener) {
            var els = document.querySelectorAll(selector);
            for (var i = 0, len = els.length; i < len; i++) {
                els[i].addEventListener(eventName, listener, false);
            }
        }

        function toggleElement(el) {
            if (el.style.display === 'none') {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        }

        function each(els, cb) {
            var i, len;
            for (i = 0, len = els.length; i < len; i++) {
                cb(els[i], i);
            }
        }

        window.addEventListener('load', function() {
            bindEvent('.stack-frame-args', 'click', function(event) {
                var target = this.dataset['target'];
                var el = document.getElementById(target);
                toggleElement(el);
                event.preventDefault();
            });

            var details = document.querySelectorAll('.stack-details');
            var frames = document.querySelectorAll('.stack-frame');
            bindEvent('.stack-frame a', 'click', function(event) {
                each(frames, function(el) {
                    el.classList.remove('active');
                });
                this.parentNode.classList.add('active');

                each(details, function(el) {
                    el.style.display = 'none';
                });

                var target = document.getElementById(this.dataset['target']);
                toggleElement(target);
                event.preventDefault();
            });

            bindEvent('.toggle-vendor-frames', 'click', function(event) {
                each(frames, function(el) {
                    if (el.classList.contains('vendor-frame')) {
                        toggleElement(el);
                    }
                });
                event.preventDefault();
            });

            bindEvent('.header-title a', 'click', function(event) {
                event.preventDefault();
                var text = '';
                each(this.parentNode.childNodes, function(el) {
                    if (el.nodeName !== 'A') {
                        text += el.textContent.trim();
                    }
                });

                // Use execCommand(copy) as it has the widest support.
                var textArea = document.createElement("textarea");
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                var el = this;
                try {
                    document.execCommand('copy');

                    // Show a success icon and then revert
                    var original = el.innerText;
                    el.innerText = '\ud83c\udf70';
                    setTimeout(function () {
                        el.innerText =  original;
                    }, 1000);
                } catch (err) {
                    alert('Unable to update clipboard ' + err);
                }
                document.body.removeChild(textArea);
                this.parentNode.parentNode.scrollIntoView(true);
            });
        });
    </script>
</body>
</html>
