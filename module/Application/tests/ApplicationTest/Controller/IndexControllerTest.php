<?php

namespace Application\Controller;

use Core\Test\ControllerTest;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;

/**
 * Testes do controller IndexController
 * 
 * @category Application
 * @package Controller
 * @author  Daniel Chaves<daniel@danielchaves.com.br>
 */

/**
 * @group Controller
 */
class IndexControllerTest extends ControllerTest
{

    /**
     * Namespace completa do Controller
     * @var string
     */
    protected $controllerFQDN = 'Application\Controller\IndexController';

    /**
     * Nome da rota. Geralmente o nome do módulo
     * @var string
     */
    protected $controllerRoute = 'application';
   
    /**
     * Testa ação index
     * @return void
     */
    public function testIndexAction()
    {
        // Invoca a rota index
        $this->routeMatch->setParam('action', 'index');
        
        $result = $this->controller->dispatch($this->request, $this->response);

        // Verifica o response
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());

        // Testa se um ViewModel foi retornado
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }
    
    
    public function testNotFoundAction()
    {
        // Invoca a rota index
        $this->routeMatch->setParam('action', 'merda');
    
        $result = $this->controller->dispatch($this->request, $this->response);
    
        // Verifica o response
        $response = $this->controller->getResponse();
    
        $this->assertEquals(404, $response->getStatusCode());
    
    }
}