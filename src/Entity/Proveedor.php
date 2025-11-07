<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $correo_electronico = null;

    #[ORM\Column(length: 20)]
    private ?string $telefono = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telefono_2 = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo_proveedor = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $fecha_creacion = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $ultima_modificacion = null;


    //getter setter

    public function getId(): ?int { return $this->id; }

    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }

    public function getCorreoElectronico(): ?string { return $this->correo_electronico; }
    public function setCorreoElectronico(string $correo_electronico): static { $this->correo_electronico = $correo_electronico; return $this; }

    public function getTelefono(): ?string { return $this->telefono; }
    public function setTelefono(string $telefono): static { $this->telefono = $telefono; return $this; }

    public function getTelefono2(): ?string { return $this->telefono_2; }
    public function setTelefono2(?string $telefono_2): static { $this->telefono_2 = $telefono_2; return $this; }

    public function getTipoProveedor(): ?string { return $this->tipo_proveedor; }
    public function setTipoProveedor(string $tipo_proveedor): static { $this->tipo_proveedor = $tipo_proveedor; return $this; }

    public function isActivo(): ?bool { return $this->activo; }
    public function setActivo(bool $activo): static { $this->activo = $activo; return $this; }

    public function getFechaCreacion(): ?\DateTimeImmutable { return $this->fecha_creacion; }
    public function getUltimaModificacion(): ?\DateTime { return $this->ultima_modificacion; }


    // Para la fecha de creacion y el update (se pone la hora justa de antes de actualizar)

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->fecha_creacion = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->ultima_modificacion = new \DateTime();
    }
}
