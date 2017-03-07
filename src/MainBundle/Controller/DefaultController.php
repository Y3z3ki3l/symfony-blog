<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * This is the homepage of your blog
     *
     * @Route("/")
     * @Route("/category/{categoryCode}")
     * @Template()
     */
    public function indexAction($categoryCode = null)
    {
        if ($categoryCode != null) {
            $doctrineObject     = $this->getDoctrine();
            $categoryRepository = $doctrineObject->getRepository('MainBundle:Category');
            $postRepository     = $doctrineObject->getRepository('MainBundle:Post');

            $category   = $categoryRepository->findOneByCode($categoryCode);
            $posts      = $postRepository->findByCategory($category);
        } else {
            $repository = $this->getDoctrine()->getRepository('MainBundle:Post');
            $posts = $repository->findAll();
        }

    	return [
            'posts' => $posts
        ];
    }

    /**
     * This is the post page
     *
     * @Route("/post/{postCode}")
     * @Template()
     */
    public function postAction($postCode)
    {
        $repository = $this->getDoctrine()->getRepository('MainBundle:Post');
        $post = $repository->findOneByCode($postCode);

        return [
            'post' => $post
        ];
    }

    /**
     * Categories div
     *
     * @Template()
     */
    public function categoriesAction() {
        $repository = $this->getDoctrine()->getRepository('MainBundle:Category');
        $categories = $repository->findAll();

        return [
            'categories' => $categories
        ];
    }
}
