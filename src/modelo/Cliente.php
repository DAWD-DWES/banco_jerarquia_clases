<?php

require_once "../src/excepciones/CuentaNoPerteneceClienteException.php";

/**
 * Clase Cliente 
 */
class Cliente {

    /**
     * DNI del cliente
     * @var string
     */
    private string $dni;

    /**
     * Nombre del cliente
     * @var string
     */
    private string $nombre;

    /**
     * Apellido1 del cliente
     * @var string
     */
    private string $apellido1;

    /**
     * Apellido2 del cliente
     * @var string
     */
    private string $apellido2;

    /**
     * Fecha de nacimiento del cliente
     * @var DateTime
     */
    private DateTime $fechaNacimiento;

    /**
     * Teléfono del cliente
     * @var string
     */
    private string $telefono;

    /**
     * Colección de identificadores de las cuentas del cliente
     * @var array
     */
    private array $idCuentas;

    public function __construct(string $dni, string $nombre, string $apellido1, string $apellido2, string $telefono, string $fechaNacimiento) {
        $this->setDni($dni);
        $this->setNombre($nombre);
        $this->setApellido1($apellido1);
        $this->setApellido2($apellido2);
        $this->setTelefono($telefono);
        $this->setFechaNacimiento(new DateTime($fechaNacimiento));
        $this->setIdCuentas([]);
    }

    public function getDni(): string {
        return $this->dni;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellido1(): string {
        return $this->apellido1;
    }

    public function getApellido2(): string {
        return $this->apellido2;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function getFechaNacimiento(): DateTime {
        return $this->fechaNacimiento;
    }

    public function getIdCuentas(): array {
        return $this->idCuentas;
    }

    public function setDni(string $dni): void {
        $this->dni = $dni;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido1(string $apellido1): void {
        $this->apellido1 = $apellido1;
    }

    public function setApellido2(string $apellido2): void {
        $this->apellido2 = $apellido2;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function setFechaNacimiento(DateTime $fechaNacimiento): void {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setIdCuentas(array $idCuentas): void {
        $this->idCuentas = $idCuentas;
    }

    /**
     * Comprueba si la cuenta pertenece al cliente
     * @param string $idCuenta
     */
    public function existeIdCuenta(string $idCuenta): bool {
        if (array_search($idCuenta, $this->getIdCuentas()) !== false) {
            return true;
        }
        else {
            throw new CuentaNoPerteneceClienteException($this->getDNI(), $idCuenta);
        }
    }

    /**
     * Alta de la cuenta en el cliente
     * @param string $idCuenta
     */
    public function altaCuenta(string $idCuenta): void {
        $this->idCuentas[] = $idCuenta;
    }

    /**
     * Baja de la cuenta en para el cliente
     * @param string $idCuenta
     */
    public function bajaCuenta(string $idCuenta): void {
        $clave = array_search($idCuenta, $this->getIdCuentas());
        // Si la clave existe en el array, elimina el elemento
        if ($clave !== false) {
            unset($this->idCuentas[$clave]);
        }
        $this->setIdCuentas(array_values($this->getIdCuentas()));
    }
}
