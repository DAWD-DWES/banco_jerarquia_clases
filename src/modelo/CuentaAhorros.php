<?php

require_once "../src/modelo/Cuenta.php";
require_once "../src/modelo/TipoCuenta.php";

/**
 * Clase CuentaAhorros 
 */
class CuentaAhorros extends Cuenta {

    private bool $libreta;

    public function __construct(string $idCliente, bool $libreta = false) {
        $this->libreta = $libreta;
        parent::__construct($idCliente, TipoCuenta::AHORROS);
    }

    public function ingreso(float $cantidad, string $descripcion, float $bonificacion = 0): void {
        $cantidadBonificada = $cantidad * (1 + ($bonificacion / 100));
        parent::ingreso($cantidadBonificada, $descripcion);
    }
    
    /**
     * 
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    public function debito(float $cantidad, string $descripcion): void {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion(TipoOperacion::DEBITO, $cantidad, $descripcion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() - $cantidad);
        } else {
            throw new SaldoInsuficienteException($this->getId(), $cantidad);
        }
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
