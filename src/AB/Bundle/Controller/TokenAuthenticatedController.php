<?php 
namespace AB\Bundle\Controller;

interface TokenAuthenticatedController
{
	public function getCsrfId();
}

?>