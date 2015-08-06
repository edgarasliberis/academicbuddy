<?php 
namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class TokenAuthenticatedController extends Controller
{
	abstract public function getCsrfId();

    public function issueCsrfTokenAction(Request $request)
    {
        $csrfManager = $this->get("security.csrf.token_manager");
        $tokenId = $this->getCsrfId();
        $tokenValue = $csrfManager->getToken($tokenId)->getValue();

        return new Response($tokenValue);
    }
}

?>