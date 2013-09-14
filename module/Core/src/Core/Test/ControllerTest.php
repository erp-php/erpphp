<?php
namespace Core\Test;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

/**
 * Classe pai dos testes dos controllers
 * @category   Core
 * @package    Test
 * @author     Elton Minetto<eminetto@coderockr.com>
 */
abstract class ControllerTest extends TestCase
{
    /**
     * O controller sendo testado
     *
     * @var Zend\Mvc\Controller\AbstractActionController
     */
    protected $controller;

    /**
     * Um objeto representando a requisição
     *
     * @var Zend\Http\Request
     */
    protected $request;

    /**
     * Um objeto representando a resposta
     *
     * @var Zend\Http\Response
     */
    protected $response;

    /**
     * Uma instância de RouteMatch usada para forçar a execução da rota
     *
     * @var Zend\Mvc\Router\RouteMatch
     */
    protected $routeMatch;

    /**
     * Uma instância de MVC event
     *
     * @var Zend\Mvc\MvcEvent
     */
    protected $event;

    /**
     * O namespace do controller sendo testado
     *
     * @var string
     */
    protected $controllerFQDN;

    /**
     * A rota correspondente ao controller, como definido na configuração das rotas do módulo
     *
     * @var string
     */
    protected $controllerRoute;

    /**
     * Faz o setup dos testes. Executado antes de cada teste
     * @return void
     */
    public function setup()
    {
        parent::setup();
        //instancia o controller
        $this->controller = new $this->controllerFQDN;
        //cria um novo request
        $this->request    = new Request();
        //cria o routeMatch baseado nas configurações do módulo/aplicação
        $this->routeMatch = new RouteMatch(
            array(
                'router' => array(
                    'routes' => array(
                        $this->controllerRoute => $this->routes[$this->controllerRoute]
                    )
                )
            )
        );
        //configura a rota para o evento de MVC corrente
        $this->event->setRouteMatch($this->routeMatch);
        
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->serviceManager);
    }


    /**
     * Executado no final de cada teste
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}