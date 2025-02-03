<?php

require_once "../src/modelo/Operacion.php";
require_once "../src/modelo/TipoCuenta.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Cuenta 
 */
abstract class Cuenta {

    /**
     * Id de la cuenta
     * @var string
     */
    private string $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo;
    
    /**
     * Tipo de la cuenta
     * @var TipoCuenta
     */
    private TipoCuenta $tipo;
    
    /**
     * Timestamp de Fecha y hora de creación de la cuenta
     * @var DateTime
     */
    private DateTime $fechaCreacion;

    /**
     * Id del cliente dueño de la cuenta
     * @var string
     */
    private string $idCliente;

    /**
     * Operaciones realizadas en la cuenta
     * @param float $saldo
     */
    private array $operaciones;

    public function __construct(string $idCliente, TipoCuenta $tipo, float $cantidad = 0) {
        $this->setId(uniqid());
        $this->setSaldo(0);
        $this->setOperaciones([]);
        $this->setFechaCreacion(new DateTime('now'));
        $this->tipo = $tipo;
        $this->ingreso($cantidad, "Ingreso inicial de $cantidad € en la cuenta");
        $this->setIdCliente($idCliente);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getIdCliente(): string {
        return $this->idCliente;
    }

    public function getOperaciones(): array {
        return $this->operaciones;
    }
    
    function getFechaCreacion(): DateTime {
        return $this->fechaCreacion;
    }
    
    function getTipo(): TipoCuenta {
        return $this->tipo;
    }


        public function setId(string $id) {
        $this->id = $id;
    }

    public function setSaldo(float $saldo) {
        $this->saldo = $saldo;
    }
    
    function setFechaCreacion(DateTime $fechaCreacion): void {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setIdCliente(string $idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setTipo(TipoCuenta $tipo) {
        $this->tipo = $tipo;
    }

    public function setOperaciones(array $operaciones) {
        $this->operaciones = $operaciones;
    }

    /**
     * Ingreso de una cantidad en una cuenta
     * @param type $cantidad Cantidad de dinero
     * @param type $descripcion Descripción del ingreso
     */
    public function ingreso(float $cantidad, string $descripcion): void {
        if ($cantidad > 0) {
            $operacion = new Operacion(TipoOperacion::INGRESO, $cantidad, $descripcion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    /**
     * Extracción de una cantidad
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    abstract public function debito(float $cantidad, string $descripcion): void;

    public function __toString() {
        $saldoFormatted = number_format($this->getSaldo(), 2); // Formatear el saldo con dos decimales
        $operacionesStr = implode("</br>", array_map(fn($operacion) => "{$operacion->__toString()}", $this->getOperaciones())); // Convertir las operaciones en una cadena separada por saltos de línea

        return "Cuenta ID: {$this->getId()}</br>" .
                "Tipo Cuenta: " . get_class($this) . "</br>" .
                "Cliente ID: {$this->getIdCliente()}</br>" .
                "Saldo: $saldoFormatted</br>" .
                "Fecha Creación: {$this->getFechaCreacion()->format('Y-m-d')}</br>" .
                "$operacionesStr";
    }

    /**
     * Agrega operación a la lista de operaciones de la cuenta
     * @param type $operacion Operación a añadir
     */
    protected function agregaOperacion(Operacion $operacion) {
        $this->operaciones[] = $operacion;
    }
}
