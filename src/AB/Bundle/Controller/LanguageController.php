<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LanguageController extends Controller
{
    private function localeRedirect(Request $request, $loc)
    {
        // Enforce selected locale.
        $request->getSession()->set('_locale', $loc); 
        $request->setLocale($loc);

        // TODO: handle missing 
        // Get route of parent URL, e.g. 'home'.
        $parentRoute = $request->get('parent_route'); 
        $parentRouteParams = is_null($request->get('parent_route_params'))? array() : $request->get('parent_route_params');

        // Generate URL with changed locale (won't pick up changes from session, have to enforce).
        $url = $this->get('router')->generate($parentRoute, array('_locale' => $loc) + $parentRouteParams);

        // As a result of previous line, URL's that don't have locale in path, will get query ?_locale=... 
        // Remove all queries as a solution
        // TODO: intelligently remove _locale, preserving other parameters, but ok for now as we don't use query
        return $this->redirect(parse_url($url, PHP_URL_PATH));
    }

    public function lithuanianAction(Request $request)
    {
        return $this->localeRedirect($request, 'lt');
    }

    public function englishAction(Request $request)
    {
        return $this->localeRedirect($request, 'en');
    }
}
