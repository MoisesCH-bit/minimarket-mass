<?php
declare(strict_types=1);

class Cliente {
    private string $dni;
    private string $nombres;
    private string $apellidos;
    private string $telefono;
    private string $email;
    private string $tipoCliente;

    public function __construct(
        string $dni,
        string $nombres,
        string $apellidos,
        string $telefono = '',
        string $email = '',
        string $tipoCliente = 'regular'
    ) {
        if (!preg_match('/^\d{8}$/', $dni)) {
            throw new InvalidArgumentException("DNI inválido: debe tener 8 dígitos");
        }
        $this->dni         = $dni;
        $this->nombres     = $nombres;
        $this->apellidos   = $apellidos;
        $this->telefono    = $telefono;
        $this->email       = $email;
        $this->tipoCliente = $tipoCliente;
    }

    public function getDni():        string { return $this->dni; }
    public function getNombres():    string { return $this->nombres; }
    public function getApellidos():  string { return $this->apellidos; }
    public function getTelefono():   string { return $this->telefono; }
    public function getEmail():      string { return $this->email; }
    public function getTipoCliente():string { return $this->tipoCliente; }

    public function nombreCompleto(): string {
        return $this->nombres . ' ' . $this->apellidos;
    }
}