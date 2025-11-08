<?php

namespace App\DataFixtures;

use App\Entity\Proveedor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProveedorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tipos = ['Hotel', 'Crucero', 'Estación de esquí', 'Parque temático'];

        for ($i = 1; $i <= 20; $i++) {
            $proveedor = new Proveedor();

            // Generar un CIF tipo A12345678 no estaran bien hechos pq son no respeta codigo de provincias, es relleno
            $letra = chr(rand(65, 90)); // A-Z mayusculas, pero la busqueda sera insensible
            $numero = str_pad((string)rand(0, 9999999), 7, '0', STR_PAD_LEFT);
            $cif = $letra . $numero;

            $proveedor->setCif($cif);
            $proveedor->setNombre("Proveedor $i");
            $proveedor->setCorreoElectronico("proveedor$i@example.com");
            // Numeros mal hechos para no llamar a nadie
            $proveedor->setTelefono("+34600" . str_pad($i, 3, '0', STR_PAD_LEFT));
            //Hara o no un numero aleatoriamente
            $proveedor->setTelefono2(rand(0, 1) ? "+34601" . str_pad($i, 3, '0', STR_PAD_LEFT) : null);
            $proveedor->setTipoProveedor($tipos[array_rand($tipos)]);
            $proveedor->setActivo((bool)rand(0, 1));

            $manager->persist($proveedor);
        }

        $manager->flush();
    }
}
