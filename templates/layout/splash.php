<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $this->fetch('header_title_top') . ' | ' . $settings['backend_name']; ?></title>

    <?= $this->Html->css('theme.min.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body class="bg-gradient-primary splash-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <?= $this->fetch('content') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" aria-live="polite" aria-atomic="true">
        <?= $this->Toast->render() ?>
    </div>

    <script src="/plugins/jquery/jquery.min.js"></script> 
    <script src="/plugins/jqueryui/jquery-ui.min.js"></script>
    <script src="/plugins/popper.min.js"></script>
    <script src="/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/plugins/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/splash.js"></script>
</body>
</html>