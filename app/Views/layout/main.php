<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech Test | CI4</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Links da esquerda -->
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('categorias') ?>" class="nav-link">Categorias</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('produtos') ?>" class="nav-link">Produtos</a>
            </li>
        </ul>

        <!-- Links da direita -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <!-- Arquitetura: Utilizando a rota /logout nativa do CodeIgniter Shield para invalidar a sessão de forma segura -->
                <a class="nav-link text-danger" href="<?= base_url('logout') ?>" title="Sair do sistema">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">Tech Test</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= base_url('categorias') ?>" class="nav-link <?= url_is('categorias*') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Categorias</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('produtos') ?>" class="nav-link <?= url_is('produtos*') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Produtos</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <?= $this->renderSection('header') ?>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <?php if (session()->getFlashdata('sucesso')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('sucesso') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('erro')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('erro') ?></div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Tech Test CI4.</strong>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>