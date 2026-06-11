<?= $this->extend('layout/main') ?>

<?= $this->section('header') ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Gerenciar Categorias</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= base_url('categorias/novo') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Nova Categoria</a>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listagem</h3>
    </div>
    <div class="card-body">
        
        <table id="tabela-categorias" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Data de Cadastro</th>
                    <th style="width: 15%">Ações</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    
    var table = $('#tabela-categorias').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?= base_url('categorias/datatable') ?>",
        "columns": [
            { "data": "id" },
            { "data": "nome" },
            { "data": "status", "orderable": false },
            { "data": "cadastro" },
            { "data": "acoes", "orderable": false, "searchable": false }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        }
    });

    window.excluirCategoria = function(id) {
        if(confirm('Tem certeza que deseja excluir/inativar esta categoria?')) {
            $.ajax({
                url: '<?= base_url('categorias/excluir/') ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert(response.mensagem);
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    let res = xhr.responseJSON;
                    alert(res.mensagem || 'Ocorreu um erro ao tentar excluir.');
                }
            });
        }
    }
});
</script>
<?= $this->endSection() ?>