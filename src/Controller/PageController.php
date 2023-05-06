<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLatest();
        return $this->render('page/index.html.twig', compact('posts'));
    }

    #[Route('posts/{slug}', name: 'home_posts_show', methods: ['GET'])]
    public function showPost(Post $post): Response
    {
        $form = $this->createForm(CommentType::class)->createView();
        return $this->render('page/posts/show.html.twig', compact('post', 'form'));
    }

    #[Route('posts/{slug}/comments', name: 'home_posts_comments_store', methods: ['POST'])]
    public function storeComment(Post $post, EntityManagerInterface $manager, Request $request): Response
    {
        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form->getData());
            $manager->flush();
            return $this->redirectToRoute('home_posts_show', ['slug' => $post->getSlug()]);
        }

        return $this->render('page/posts/show.html.twig', compact('post', 'form'));
    }
}
