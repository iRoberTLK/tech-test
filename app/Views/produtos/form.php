<?= $this->extend('layout/main') ?>

<?php
$isEdit = isset($produto);
$action = $isEdit ? base_url('produtos/atualizar/' . $produto->pro_id) : base_url('produtos/salvar');
$erros  = session()->get('erros');
?>

<?= $this->section('header') ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><?= $isEdit ? 'Editar Produto' : 'Novo Produto' ?></h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= base_url('produtos') ?>" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form action="<?= $action ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="form-group">
                <label for="pro_nome">Nome do Produto <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($erros['pro_nome']) ? 'is-invalid' : '' ?>" 
                       id="pro_nome" name="pro_nome" 
                       value="<?= old('pro_nome', $isEdit ? $produto->pro_nome : '') ?>" required maxlength="255">
                <?php if(isset($erros['pro_nome'])): ?>
                    <div class="invalid-feedback"><?= $erros['pro_nome'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Arquitetura: Reutilizando o endpoint da API de Categorias para alimentar o Select2 aqui -->
            <div class="form-group">
                <label for="cat_id">Categoria Vinculada <span class="text-danger">*</span></label>
                <select class="form-control <?= isset($erros['cat_id']) ? 'is-invalid' : '' ?>" id="cat_id" name="cat_id" required>
                    <?php if($isEdit || old('cat_id')): ?>
                        <option value="<?= old('cat_id', $isEdit ? $produto->cat_id : '') ?>" selected>
                            <?= isset($categoriaNome) ? $categoriaNome : 'Categoria Selecionada' ?>
                        </option>
                    <?php endif; ?>
                </select>
                <?php if(isset($erros['cat_id'])): ?>
                    <div class="invalid-feedback"><?= $erros['cat_id'] ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#cat_id').select2({
        placeholder: 'Busque e selecione uma categoria...',
        ajax: {
            url: '<?= base_url('categorias/buscar-ajax') ?>',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data.results };
            },
            cache: true
        }
    });
});
</script>
<?= $this->endSection() ?>