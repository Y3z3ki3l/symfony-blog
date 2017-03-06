<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Post controller.
 *
 * @Route("secure/post")
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="secure_post_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('MainBundle:Post')->findAll();

        return [
            'posts' => $posts,
        ];
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="secure_post_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('MainBundle\Form\PostType', $post);
        // Remove certain fiels that are calculated like created_at and code
        $form->remove('createdAt');
        $form->remove('code');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Calculating the code for the URL
            $utility = new \Helper\UtilityHelper();
            $code = $utility->removeSpecialCharacter($form->get('title')->getData());
            $post->setCode($code);

            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('secure_post_show', array('id' => $post->getId()));
        }

        return [
            'post' => $post,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="secure_post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return [
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="secure_post_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('MainBundle\Form\PostType', $post);
        $editForm->remove('createdAt');


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secure_post_edit', array('id' => $post->getId()));
        }

        return [
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="secure_post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush($post);
        }

        return $this->redirectToRoute('secure_post_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('secure_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
