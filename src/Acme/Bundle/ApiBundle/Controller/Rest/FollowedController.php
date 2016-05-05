<?php
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

use JMS\Serializer\SerializationContext;

use Acme\Bundle\ApiBundle\Entity\Followed;

/**
 * FollowedController 
 * @author F. Bérubé, E. Gélinas Gagnon
 * 
   $this->getUser()->getId();
   $this->getUser()->getUsername();
   $this->getUser()->getRoles();
 * @Security("has_role('ROLE_API')")
 * @FOSRest\NamePrefix("api_")
 */
 class FollowedController extends FOSRestController
 {
 	public function deleteFollowedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entityToDelete = $em->getRepository('AcmeApiBundle:Followed')->find($id);

        if ($entityToDelete == null) 
        {
            $data=array(
                "code"=> 410,
                "message"=> "Not found",
                );
            $view = $this->view($data, 410);
            return $this->handleView($view);
        } 
        else 
        {
            if ($this->getUser()->getId() != $entityToDelete->getUser()->getId()) {
                throw new AccessDeniedException();
            }
            $em->remove($entityToDelete);
            $em->flush();
        }
    }

 }