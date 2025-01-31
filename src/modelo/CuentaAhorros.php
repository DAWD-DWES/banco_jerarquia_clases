<?php

require_once "Cuenta.php";

/**
 * Clase CuentaAhorros 
 */
class CuentaAhorros extends Cuenta {

    private bool $libreta;

    public function __construct(string $idCliente, float $saldo = 0, float $bonificacion = 0, bool $libreta = false) {
        $this->libreta = $libreta;
        $saldoBonificado = $saldo * (1 + ($bonificacion / 100));
        parent::__construct($idCliente, $saldoBonificado);
    }

    public function ingreso(float $cantidad, string $descripcion, float $bonificacion = 0): void {
        $cantidadBonificada = $cantidad * (1 + ($bonificacion / 100));
        parent::ingreso($cantidadBonificada, $descripcion);
    }

    public function getLibreta(): bool {
        return $this->libreta;
    }

    public function setLibreta(bool $libreta): void {
        $this->libreta = $libreta;
    }

    public function aplicaInteres(float $interes): void {
        $intereses = $this->getSaldo() * $interes / 100;
        $this->ingreso($intereses, "Intereses a tu favor.");
    }

    public function __toString() {
        return (parent::__toString() . "<br> Libreta: " . ($this->getLibreta() ? "Si" : "No") . "</br>");
    }
}
