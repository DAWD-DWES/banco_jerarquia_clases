<?php

require_once "../src/modelo/Cuenta.php";
require_once "../src/modelo/TipoCuenta.php";

/**
 * Clase CuentaCorriente 
 */
class CuentaCorriente extends Cuenta {

    public function __construct(string $idCliente, float $saldo = 0) {
        parent::__construct($idCliente, TipoCuenta::CORRIENTE, $saldo);
    }

    public function aplicaComision($comision, $minSaldo): void {
        if ($this->getSaldo() < $minSaldo) {
            $this->debito($comision, "Cargo de comisión de mantenimiento");
        }
    }

    /**
     * 
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    public function debito(float $cantidad, string $descripcion): void {
        $operacion = new Operacion(TipoOperacion::DEBITO, $cantidad, $descripcion);
        $this->agregaOperacion($operacion);
        $this->setSaldo($this->getSaldo() - $cantidad);
    }
}
