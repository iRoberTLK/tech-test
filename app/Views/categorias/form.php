<?= $this->extend('layout/main') ?>

<?php
// Arquitetura: Reuso da mesma view para Create e Update
$isEdit = isset($categoria);
$action = $isEdit ? base_url('categorias/atualizar/' . $categoria->cat_id) : base_url('categorias/salvar');
$erros  = session()->get('erros');
?>

<?= $this->section('header') ?>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><?= $isEdit ? 'Editar Categoria' : 'Nova Categoria' ?></h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?= base_url('categorias') ?>" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary">
    <form action="<?= $action ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="card-body">
            <div class="form-group">
                <label for="cat_nome">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($erros['cat_nome']) ? 'is-invalid' : '' ?>" 
                       id="cat_nome" name="cat_nome" 
                       value="<?= old('cat_nome', $isEdit ? $categoria->cat_nome : '') ?>" required maxlength="100">
                <?php if(isset($erros['cat_nome'])): ?>
                    <div class="invalid-feedback"><?= $erros['cat_nome'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="cat_descricao">Descrição</label>
                <textarea class="form-control" id="cat_descricao" name="cat_descricao" rows="3"><?= old('cat_descricao', $isEdit ? $categoria->cat_descricao : '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="cat_ativo">Status</label>
                <select class="form-control" id="cat_ativo" name="cat_ativo">
                    <option value="1" <?= old('cat_ativo', $isEdit ? $categoria->cat_ativo : '1') == '1' ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= old('cat_ativo', $isEdit ? $categoria->cat_ativo : '1') == '0' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>