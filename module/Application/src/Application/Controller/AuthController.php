<?php
namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

/**
 * AuthController
 *
 * PHP version 5.4
 *
 * @category   SegAdmin
 * @package    Application
 * @subpackage Auth
 * @author     Daniel Chaves <daniel@danielchaves.com.br>
 * @license    http://mywedding.com.br/licence MIT
 * @link       none
 */

class AuthController extends CoreController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        return $view;

    }

    public function authAction()
    {

    }

    public function logoutAction()
    {

    }
}
