<!-- Arquitetura: View Parcial para manter o controller limpo de HTML e facilitar manutenção -->
<div class="btn-group">
    <a href="<?= base_url('categorias/editar/' . $id) ?>" class="btn btn-sm btn-info" title="Editar">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger" onclick="excluirCategoria(<?= $id ?>)" title="Excluir">
        <i class="fas fa-trash"></i>
    </button>
</div>