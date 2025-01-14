<?php

namespace App\Helpers;

use DateTime;

class TableHelper
{
    public static function renderPagamentosTable($pagamentos)
    {
        ob_start(); // Inicia o buffer de saída para capturar o HTML gerado
?>
        <table id="dataTablePagamentos" class="datatable table table-striped nowrap table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="desktop">OP</th>
                    <th class="desktop mobile tablet">Morador</th>
                    <th class="desktop mobile tablet">Quadra</th>
                    <th class="desktop mobile tablet">Nr da Casa</th>
                    <th class="desktop mobile tablet">Data Pagto</th>
                    <th class="none">Data Venc</th>
                    <th class="desktop mobile tablet">Ref.</th>
                    <th class="desktop tablet">Recebedor</th>
                    <th class="desktop mobile tablet">Valor</th>
                    <th class="desktop mobile tablet">Situação</th>
                    <th class="desktop mobile tablet">Forma</th>
                    <th class="desktop mobile tablet">Tipo</th>
                    <th class="none">Obs</th>
                    <th class="desktop mobile tablet">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagamentos as $pagamento): ?>
                    <?php
                    $situacaoClass = match ($pagamento->situacao) {
                        'PAGO' => '<label class="badge badge-success">' . $pagamento->situacao . '</label>',
                        'PENDENTE' => '<label class="badge badge-warning">' . $pagamento->situacao . '</label>',
                        'CANCELADO' => '<label class="badge badge-danger">' . $pagamento->situacao . '</label>',
                        'ABERTO' => '<label class="badge badge-info">' . $pagamento->situacao . '</label>',
                        default => '<label class="badge badge-warning">Indefinido</label>',
                    };

                    $dataVencimento = new DateTime($pagamento->data_vencimento);
                    $dataVencimentoFormatada = $dataVencimento->format('Y-m-d');
                    $dataAtual = new DateTime("now");
                    $dataAtualFormatada = $dataAtual->format('Y-m-d');
                    $class = '';

                    if ($pagamento->situacao === 'ABERTO') {
                        $class = match (true) {
                            $dataVencimentoFormatada < $dataAtualFormatada => 'text-danger font-weight-bold',
                            $dataVencimentoFormatada === $dataAtualFormatada => 'text-warning font-weight-bold',
                            default => '',
                        };
                    }
                    ?>

                    <tr>
                        <td><?= $pagamento->id_pagamento ?></td>
                        <td><?= $pagamento->nome_morador ?></td>
                        <td><?= $pagamento->quadra ?></td>
                        <td><?= $pagamento->numero ?></td>
                        <td><?= date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                        <td><span class="<?= $class ?>"><?= date('d/m/Y', strtotime($pagamento->data_vencimento)) ?></span></td>
                        <td><?= $pagamento->referencia ?></td>
                        <td><?= $pagamento->nome_recebedor ?></td>
                        <td><?= number_format($pagamento->valor, 2, ',', '.') ?></td>
                        <td><?= $situacaoClass ?></td>
                        <td><?= $pagamento->desc_forma_pagto ?></td>
                        <td><?= $pagamento->desc_pagamento ?></td>
                        <td><?= $pagamento->observacao ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-rounded" type="button" id="actionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                    <?php if($pagamento->role == 'admin'):?>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url('/pagamento/editar/' . $pagamento->id_pagamento); ?>">
                                            <i class="mdi mdi-pencil"></i> Editar
                                        </a>
                                    </li>
                                    <?php endif;?>
                                    <?php if ($pagamento->stored_name != ''): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo base_url('/pagamento/downloadPagamento/' . $pagamento->stored_name); ?>" target="_blank">
                                                <i class="mdi mdi-eye"></i> Anexo
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8"></th>
                    <th>Total</th>
                    <th colspan="5"></th>
                </tr>
            </tfoot>
        </table>
<?php
        return ob_get_clean(); // Retorna o conteúdo gerado como string
    }
}
