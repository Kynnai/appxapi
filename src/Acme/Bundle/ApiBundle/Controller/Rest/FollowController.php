namespace Acme\Bundle\ApiBundle\Controller\Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

use Acme\Bundle\ApiBundle\Entity\Follow;

/**
 * FollowController 
 * @author F. Bérubé, E. Gélinas Gagnon
 * 
   $this->getUser()->getId();
   $this->getUser()->getUsername();
   $this->getUser()->getRoles();
 * @Security("has_role('ROLE_API')")
 * @FOSRest\NamePrefix("api_")
 */
 class FollowController extends FOSRestController
 {

 }