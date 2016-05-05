<?php
namespace Acme\Bundle\ApiBundle\Controller\Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;

use Acme\Bundle\ApiBundle\Entity\Follow;

/**
 * FollowController 
 * @author F. Bérubé, E. Gélinas Gagnon
 *
 * @Security("has_role('ROLE_API')")
 * @FOSRest\NamePrefix("api_")
 */
 class FollowController extends FOSRestController
 {

     /**
      * @throws AccessDeniedException
      * @ApiDoc(
      *  description="Create one follow for the user",
      *  authentication=true,
      *  authenticationRoles={"ROLE_API"},
      *  input={
      *     "class"="Acme\Bundle\ApiBundle\Form\FollowType",
      *     },
      *     statusCodes={
      *         201="Add successfully",
      *         401="Unauthorized",
      *         403="Validation errors"
      *     }
      * )
      * @FOSRest\View(statusCode=201)
      * @ParamConverter("fav", class="Acme\Bundle\ApiBundle\Entity\Follow", converter="fos_rest.request_body")
      * @Post("/follow")
      */
     public function postFollowAction(Request $request, Follow $follow)
     {
         $follow->setUserId($this->getUser()->getId());
         $follow->setStatus(true);

         $validator = $this->get('validator');
         $errors = $validator->validate($follow);

         if (count($errors) > 0)
         {
             $view = $this->view($errors, 403);
             return $this->handleView($view);
         }
         else
         {
             $em = $this->getDoctrine()->getManager();
             $em->persist($follow);
             $em->flush();
             return $follow;
         }
     }
 }

?>