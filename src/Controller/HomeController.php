<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Si es administrador, lo enviamos al listado de proveedores 
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_proveedores');
        }

        // Si es solo viewer tambien (los permisos se dictan ahí)
        if ($this->isGranted('ROLE_VIEWER')) {
            return $this->redirectToRoute('app_proveedores');
        }

        // Si no está logueado o no tiene rol válido, lo mandamos al login
        return $this->redirectToRoute('app_login');
    }
}
