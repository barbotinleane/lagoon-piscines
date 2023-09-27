<?php

namespace App\Controller;

use App\Repository\FormationLibellesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/***
 * Controller called to display documentation for each formation in a pdf reader
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class DocController extends AbstractController
{
    #[Route('/documentation/rgpd', name: 'app_doc_rgpd')]
    public function rgpd(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'RGPD',
            'name' => 'Règlement Général pour la Protection des Données',
        ]);
    }

    #[Route('/documentation/cgv', name: 'app_doc_cgv')]
    public function cgv(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'conditions_generales_vente',
            'name' => 'Conditions Générales de Vente',
        ]);
    }

    #[Route('/documentation/charte-qualite', name: 'app_doc_quality')]
    public function quality(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'charte_qualite',
            'name' => 'Charte de qualité'
        ]);
    }

    #[Route('/documentation/programme/{formationId}', name: 'app_doc_program')]
    public function program($formationId, FormationLibellesRepository $flRepo): Response
    {
        $formation = $flRepo->find($formationId);
        $programFilename = $formation->getProgramName();

        return $this->render('formation/show/doc/program.html.twig', [
            'fileName' => $programFilename,
            'name' => 'Programme de la formation '.$formation->getLibelle(),
        ]);
    }

    #[Route('/documentation/livret-accueil', name: 'app_doc_livret')]
    public function livret(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'livret_accueil',
            'name' => 'Livret d\'accueil'
        ]);
    }

    #[Route('/documentation/reglement-interieur', name: 'app_doc_reglement')]
    public function reglement(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'reglement_interieur',
            'name' => 'Règlement intérieur de LAGOON Formations'
        ]);
    }

    #[Route('/documentation/certification-qualiopi', name: 'app_doc_qualiopi')]
    public function qualiopi(): Response
    {
        return $this->render('formation/show/doc/index.html.twig', [
            'fileName' => 'certificat_qualiopi',
            'name' => 'Certification Qualiopi'
        ]);
    }
}
