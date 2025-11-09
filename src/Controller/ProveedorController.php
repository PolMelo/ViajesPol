<?php

namespace App\Controller;

use App\Entity\Proveedor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
// VALIDADOR DE SYMFONY PARA VERIFICAR FORMATO DE EMAIL
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProveedorController extends AbstractController
{
    #[Route('/proveedores', name: 'app_proveedores')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Proveedor::class);
        // Get para obtener el repositorio de la entidad Proveedor

        $id = $request->query->get('id');
        $cif = $request->query->get('cif');
        $nombre = $request->query->get('nombre');
        $correo = $request->query->get('correo');
        $activo = $request->query->get('activo');
        $tipo = $request->query->get('tipo_proveedor');

        // Construimos la consulta
        $qb = $repo->createQueryBuilder('p');

        if ($id) $qb->andWhere('p.id = :id')->setParameter('id', $id);
        if ($cif) $qb->andWhere('LOWER(p.cif) LIKE LOWER(:cif)')->setParameter('cif', "%$cif%");
        if ($nombre) $qb->andWhere('LOWER(p.nombre) LIKE LOWER(:nombre)')->setParameter('nombre', "%$nombre%");
        if ($correo) $qb->andWhere('LOWER(p.correo_electronico) LIKE LOWER(:correo)')->setParameter('correo', "%$correo%");
        if ($activo !== null && $activo !== '') $qb->andWhere('p.activo = :activo')->setParameter('activo', $activo === 'true');
        if ($tipo) $qb->andWhere('LOWER(p.tipo_proveedor) LIKE LOWER(:tipo)')->setParameter('tipo', "%$tipo%");

        $proveedores = $qb->orderBy('p.id', 'ASC')->getQuery()->getResult();

        return $this->render('proveedor/index.html.twig', [
            'proveedores' => $proveedores,
            'filtros' => [
                'id' => $id,
                'cif' => $cif,
                'nombre' => $nombre,
                'correo' => $correo,
                'activo' => $activo,
                'tipo_proveedor' => $tipo,
            ],
        ]);
    }

    // Lo de arriba lo pueden ver ROLE VIEWER Y ROLE ADMIN, a partir de aqui solo ROLE ADMIN

    //Vamos a proveedores nuevo

    #[Route('/proveedores/nuevo', name: 'app_proveedor_nuevo')]
    #[IsGranted('ROLE_ADMIN')]
    public function nuevo(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        // Si solicito crear, me hace un new proveedor obteniendo los datos que le pase, solo uno puede ser null (el segundo telefono)
        if ($request->isMethod('POST')) {
            $proveedor = new Proveedor();
            $proveedor
                ->setCif($request->request->get('cif'))
                ->setNombre($request->request->get('nombre'))
                ->setCorreoElectronico($request->request->get('correo'))
                ->setTelefono($request->request->get('telefono'))
                ->setTelefono2($request->request->get('telefono2') ?: null)
                ->setTipoProveedor($request->request->get('tipo_proveedor'))
                ->setActivo($request->request->get('activo') === 'on');

            // validamos la entity (email formato email)
            $errores = $validator->validate($proveedor);

            if (count($errores) > 0) {
                $mensajes = [];
                foreach ($errores as $error) {
                    $mensajes[] = $error->getPropertyPath() . ': ' . $error->getMessage();
                }

                // si falla feedback y al form
                return $this->render('proveedor/form.html.twig', [
                    'proveedor' => $proveedor,
                    'accion' => 'nuevo',
                    'titulo' => 'Añadir nuevo proveedor',
                    'errores' => $mensajes,
                ]);
            }

            // todo ok guardamos
            $em->persist($proveedor);
            $em->flush();

            $this->addFlash('success', 'Proveedor creado correctamente.');
            return $this->redirectToRoute('app_proveedores');
        }

        $proveedor = new Proveedor();

        return $this->render('proveedor/form.html.twig', [
            'proveedor' => $proveedor,
            'accion' => 'nuevo',
            'titulo' => 'Añadir nuevo proveedor',
        ]);
    }

    #[Route('/proveedores/{id}/editar', name: 'app_proveedor_editar')]
    #[IsGranted('ROLE_ADMIN')]
    public function editar(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $proveedor = $em->getRepository(Proveedor::class)->find($id);
        if (!$proveedor) throw $this->createNotFoundException('Proveedor no encontrado');

        if ($request->isMethod('POST')) {
            $proveedor
                ->setCif($request->request->get('cif'))
                ->setNombre($request->request->get('nombre'))
                ->setCorreoElectronico($request->request->get('correo'))
                ->setTelefono($request->request->get('telefono'))
                ->setTelefono2($request->request->get('telefono2') ?: null)
                ->setTipoProveedor($request->request->get('tipo_proveedor'))
                ->setActivo($request->request->get('activo') === 'on');

            // validamos email y demas
            $errores = $validator->validate($proveedor);

            if (count($errores) > 0) {
                $mensajes = [];
                foreach ($errores as $error) {
                    $mensajes[] = $error->getPropertyPath() . ': ' . $error->getMessage();
                }

                // si falla devolvemos al form y feedback
                return $this->render('proveedor/form.html.twig', [
                    'proveedor' => $proveedor,
                    'accion' => 'editar',
                    'titulo' => 'Editar proveedor',
                    'errores' => $mensajes,
                ]);
            }

            // si esta bien guardamos y damos feedback
            $em->flush();

            $this->addFlash('success', 'Proveedor actualizado correctamente.');
            return $this->redirectToRoute('app_proveedores');
        }

        return $this->render('proveedor/form.html.twig', [
            'proveedor' => $proveedor,
            'accion' => 'editar',
            'titulo' => 'Editar proveedor',
        ]);
    }

    #[Route('/proveedores/{id}/eliminar', name: 'app_proveedor_eliminar', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function eliminar(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $proveedor = $em->getRepository(Proveedor::class)->find($id);
        if (!$proveedor) throw $this->createNotFoundException('Proveedor no encontrado');

        if ($this->isCsrfTokenValid('eliminar' . $proveedor->getId(), $request->request->get('_token'))) {
            $em->remove($proveedor);
            $em->flush();
            $this->addFlash('success', 'Proveedor eliminado correctamente.');
        }

        return $this->redirectToRoute('app_proveedores');
    }
}
