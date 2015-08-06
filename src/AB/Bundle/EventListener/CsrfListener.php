<?php 

namespace AB\Bundle\EventListener;

use AB\Bundle\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CsrfListener
{
    private $csrfManager;

    public function __construct(CsrfTokenManagerInterface $csrfManager) {
        $this->csrfManager = $csrfManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof TokenAuthenticatedController) {
            if(!in_array($event->getRequest()->getMethod(), array('POST', 'PUT', 'DELETE', 'PATCH'))) {
                return;
            }

            // Validate passed token
            $tokenId = $controller[0]->getCsrfId();
            $tokenValue = $event->getRequest()->headers->get('X-CSRF-Token');

            if (!$tokenValue || !$this->csrfManager->isTokenValid(new CsrfToken($tokenId, $tokenValue))) {
                throw new AccessDeniedHttpException('Invalid CSRF token.');
            }

            $event->getRequest()->attributes->set('X-Passed-CSRF', $tokenId);
        }
    }
}

?>