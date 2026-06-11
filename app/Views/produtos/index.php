<?= $this->extend('layout/main') ?>

<?= $this->section('header') ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Gerenciar Produtos</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= base_url('produtos/novo') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Produto</a>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <table id="tabela-produtos" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 10%">ID</th>
                    <th>Nome do Produto</th>
                    <th>Categoria Vinculada</th>
                    <th style="width: 15%">Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    var table = $('#tabela-produtos').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?= base_url('produtos/datatable') ?>",
        "columns": [
            { "data": "id" },
            { "data": "nome" },
            { "data": "categoria" },
            { "data": "acoes", "orderable": false, "searchable": false }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        }
    });

    window.excluirProduto = function(id) {
        if(confirm('Tem certeza que deseja excluir este produto?')) {
            $.ajax({
                url: '<?= base_url('produtos/excluir/') ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert(response.mensagem);
                    table.ajax.reload(null, false);
                }
            });
        }
    }
});
</script>
<?= $this->endSection() ?>