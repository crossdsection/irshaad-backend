<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Core\Configure;
use Firebase\JWT\JWT;
use Cake\Core\Exception\Exception;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;
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
        if( $conActions['controller'] == $request->getParam('controller') && $conActions['action'] == $request->getParam('action') ){
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
                    if( $token->expiration_time >= time() ){
                      $request->data['userId'] = $token->user_id;
                      $response = $next($request, $response);
                    } else {
                      throw new Exception(__('Token Expired'));
                    }
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
        $response = $next($request, $response);
      }
      return $response;
    }
}
