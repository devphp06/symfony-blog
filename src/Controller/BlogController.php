<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\PostType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", methods="GET", name="app_blog")
     */
    public function index(BlogRepository $blog): Response
    {
        $allPosts = $blog->findAll();
        return $this->render('blog/index.html.twig', [
            'allPosts' => $allPosts,
        ]);
    }

    /**
     * @Route("/add-post", methods="GET|POST", name="add_post")
     */
    public function addPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Blog();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post Added Successfully');

            return $this->redirectToRoute('app_blog');
        }

        return $this->renderForm('blog/addPost.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit-post", methods="GET|POST", name="edit_post")
     */
    public function editPost($id, Request $request, BlogRepository $blog, EntityManagerInterface $entityManager): Response
    {
        $post = $blog->find($id);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Post Updated Successfully');

            return $this->redirectToRoute('app_blog');
        }

        return $this->renderForm('blog/editPost.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", methods="GET", name="delete_post")
     */
    public function delete($id, Request $request, BlogRepository $blog, EntityManagerInterface $entityManager): Response
    {
        $post = $blog->find($id);

        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash('success', 'Post Deleted Successfully');

        return $this->redirectToRoute('app_blog');
    }
}
