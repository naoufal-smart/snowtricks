<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Image;
use App\Form\FigureType;
use App\Entity\Group;
use App\Repository\FigureRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/figure")
 */
class FigureController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(Security $security, MailerInterface $mailer)
    {
        $this->security = $security;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", name="figure_index", methods={"GET"})
     */
    public function index(FigureRepository $figureRepository): Response
    {
        return $this->render('figure/index.html.twig', [
            'figures' => $figureRepository->findAllFigureWithRelatedMainImages(),
            'bodyCssClass' => 'homepage'
        ]);
    }

    /**
     * @Route("/new", name="figure_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {

        if ($this->isGranted('ROLE_USER') == false) {
            throw new AccessDeniedHttpException('Permission refusée');
        }

        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $figure->setUser($this->security->getUser());

            $imagesForm = $form->get('images');

/*            dump($figure->getImages()); // Données brutes postées
            dd($imagesForm);*/

            foreach ($imagesForm as $key => $imageForm){
                $uploadedFile = $imageForm->get('filename')->getData();
                if($uploadedFile !== null){
                    // Upload Image
                    $newFilename = $imageUploader->upload($uploadedFile, null);
                    $image = new Image();
                    $image->setFilename($newFilename);
                    $image->setName($imageForm->get('name')->getData());
                    if($key == 0){
                        $image->setIsMain(true);
                    }
                    $figure->addImage($image);
                    // Delete Submitted Field
                    $originalData = $figure->getImages()[$key];
                    $figure->removeImage($originalData);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Création effectuée avec succès');

            $email = (new Email())
                ->from('postmaster@snowtricks.com')
                ->to('admin@snowtricks.com')
                 ->subject('Nouvelle figure')
                ->text('Nouvelle figure')
                ->html('<p>'.$figure->getId().'</p>');
            $this->mailer->send($email);

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/new.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
            'bodyCssClass' => 'figure_creation'
        ]);
    }

    /**
     * @Route("/{slug}", name="figure_show", methods={"GET"})
     */
    public function show(Figure $figure): Response
    {

        return $this->render('figure/show.html.twig', [
            'figure' => $figure,
            'bodyCssClass' => 'figure'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Figure $figure, ImageUploader $imageUploader): Response
    {

        $user = $this->security->getUser();

        if($user == null || ($figure->getUser() !== $user && !$this->isGranted('ROLE_ADMIN'))){
            throw new AccessDeniedHttpException('Permission refusée');
        }

        $form = $this->createForm(FigureType::class, $figure);

        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            if($form->isValid()){

                $imagesForm = $form->get('images');

                foreach ($imagesForm as $key => $imageForm){
                    $uploadedFile = $imageForm->get('filename')->getData();
                    if($uploadedFile !== null){
                        // Upload Image
                        $newFilename = $imageUploader->upload($uploadedFile, null);
                        $image = new Image();
                        $image->setFilename($newFilename);
                        $image->setName($imageForm->get('name')->getData());
                        $figure->addImage($image);
                        // Delete Submitted Field !!!
                        // dump($figure->getImages()); // Données brutes postées
                        $originalData = $figure->getImages()[$key];
                        $figure->removeImage($originalData);
                    }
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($figure);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succès');
                return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
            }
        }

        return $this->render('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
            'bodyCssClass' => 'figure-edition'
        ]);
    }

    /**
     * @Route("/{id}", name="figure_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Figure $figure): Response
    {
        $user = $this->security->getUser();

        if($user == null || ($figure->getUser() !== $user && !$this->isGranted('ROLE_ADMIN'))){
            throw new AccessDeniedHttpException('Permission refusée');
        }

        if ($this->isCsrfTokenValid('delete'.$figure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Suppression effectuée avec succès');

        }

        return $this->redirectToRoute('figure_index');
    }
}
