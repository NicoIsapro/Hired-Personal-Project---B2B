<?php

namespace Website\WebBundle\Security\Authentication\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected
        $router,
        $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $url = 'root';
        if($this->security->isGranted('ROLE_ADMIN')) {
            $url = 'admin';
        }
        elseif($this->security->isGranted('ROLE_CLIENT')) {
            $url = 'clients';
        }
        $response = new RedirectResponse($this->router->generate($url));

        return $response;
    }
}