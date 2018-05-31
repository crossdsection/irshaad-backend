<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Core\Configure;
use Firebase\JWT\JWT;

/**
 * Authorization middleware
 */
class AuthorizationMiddleware
{

    /**
     * Invoke method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param callable $next Callback to invoke the next middleware.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
      $flagAllow = false;
      $allowedConActions = array();
      $allowedConActions[] = array( 'controller' => 'WvUser', 'action' => 'login' );
      $allowedConActions[] = array( 'controller' => 'WvUser', 'action' => 'signup' );
      foreach( $allowedConActions as $conActions ){
        if( $conActions['controller'] == $request->params['controller'] && $conActions['action'] == $request->params['action'] ){
          $flagAllow = true;
        }
      }
      if( !$flagAllow ){
        $errorRes = array( 'error' => 1, 'message' => '' );
        $authHeader = $request->getHeader('authorization');
        if ($authHeader) {
            list( $jwt ) = sscanf( $authHeader[0], ': Bearer %s');
            if ( $jwt ) {
                try {
                    $secretKey = Configure::read('jwt_secret_key');
                    $token = JWT::decode($jwt, $secretKey, array('HS512'));
                    return $next($request, $response);
                } catch (Exception $e) {
                    throw new UnauthorizedException(__('Illegal Token'));
                }
            } else {
                throw new BadRequestException(__('Bad request'));
            }
        } else {
            throw new BadRequestException(__('Bad request'));
        }
      } else {
        return $next($request, $response);
      }

    }
}
