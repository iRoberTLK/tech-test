<div class="btn-group">
    <a href="<?= base_url('produtos/editar/' . $id) ?>" class="btn btn-sm btn-info" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="excluirProduto(<?= $id ?>)" title="Excluir">
        <i class="fas fa-trash"></i>
    </button>
</div>