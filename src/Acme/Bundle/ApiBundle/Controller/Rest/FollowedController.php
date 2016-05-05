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
   /** 
    @throws AccessDeniedException
     *
     * @ApiDoc(
     *  resource=true,
     *  resource="/api/allFollowed",
     *  description="Get all followed for the user",
     *  tags={"Special route"},
     *  statusCodes={
     *      200="Successful",
     *      401="Unauthorized",
     *     },
     * )
     * @Security("has_role('ROLE_API')")
     * @return array
     *
     */
    public function getAllFollowedMeAction()
    {
        $userId = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeApiBundle:Followed')->findBy(
            array('userId'=>$userId)); 

        $view = $this->view($entities, 200);
        return $this->handleView($view);
    }

    /**
     * @param int $id
     * 
     * @ApiDoc(
     *  description="Get one followed item",
     *  authentication=true,
     *  authenticationRoles={"ROLE_API"},
     *  statusCodes={
     *      200="Successful",
     *      401="Unauthorized",
     *      410={
     *        "Returned when the comment is not found",
     *        "Returned when something else is not found"
     *      }
     *   }
     * )
     *
     * @throws AccessDeniedException
     * @return Followed
     *
     * @FOSRest\View()
     */
    public function getFollowedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $followed = $em->getRepository('AcmeApiBundle:Followed')->find($id);

        if ($followed == null) 
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
            return $followed;
        }
    }



    /**
     * @throws AccessDeniedException
     * @ApiDoc(
     *  description="Delete one followed user",
     *  authentication=true,
     *  authenticationRoles={"ROLE_API"},
     *  statusCodes={
     *      200="Deleted successfully",
     *      401="Unauthorized",
     *      410="Not found or already deleted"
     *  }
     * )
     * @FOSRest\View(statusCode=200)
     */
    public function deleteFollowedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $followedToDelete = $em->getRepository('AcmeApiBundle:Followed')->find($id);

        if ($followedToDelete == null) 
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
            if ($this->getUser()->getId() != $followedToDelete->getUserId()) {
                throw new AccessDeniedException();
            }
            $em->remove($followedToDelete);
            $em->flush();
        }
    }

 }