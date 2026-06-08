<?php

namespace App\Services;

use App\Models\Caixa;
use App\Models\ContaReceber;
use App\Repositories\CaixaRepository;
use Exception;

class CaixaService{
    private CaixaRepository $caixaRepository;

    public function __construct(){
        $this->caixaRepository = new CaixaRepository();
    }

    public function baixarContaReceber(ContaReceber $contaReceber): void{
        try{
            $movimentoContaReceber = new Caixa();

            $movimentoContaReceber->setValor($contaReceber->getValorPago());
            $movimentoContaReceber->setOrigem($contaReceber->getOrigem());
            $movimentoContaReceber->setDescricao($contaReceber->getDescricao());
            $movimentoContaReceber->setContaCaixaId($contaReceber->getId());
            $movimentoContaReceber->setContaReceberId($contaReceber->getId());
            $movimentoContaReceber->setFormaPagamentoId($contaReceber->getFormaPagamentoId());
            $movimentoContaReceber->setTipoMovimento('ENTRADA');

            $this->caixaRepository->movimentarCaixa($movimentoContaReceber);
        } catch (Exception $e) {
            throw $e;
        }
    }
}