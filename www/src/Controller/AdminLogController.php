<?php

namespace App\Controller;

use App\Document\LogConnexion;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLogController extends AbstractController
{
    #[Route('/admin/logs', name: 'admin_logs')]
    public function logs(DocumentManager $dm): Response
    {
        // Vérifie que l'utilisateur a le rôle ADMIN
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Récupère tous les logs, triés par date décroissante
        $logs = $dm->getRepository(LogConnexion::class)->findBy([], ['date' => 'DESC']);

        return $this->render('admin/logs.html.twig', [
            'logs' => $logs,
        ]);
    }
}
