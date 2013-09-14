<?php
namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

/**
 * IndexController
 *
 * PHP version 5.4
 *
 * @category   MyWedding
 * @package    Application
 * @subpackage Index
 * @author     Daniel Chaves <daniel@danielchaves.com.br>
 * @license    http://mywedding.com.br/licence MIT
 * @link       none
 */

class IndexController extends CoreController
{

    /**
     * Index Controller
     * (non-PHPdoc)
     *
     * @see    Zend\Mvc\Controller\AbstractActionController::indexAction()
     * @return Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();

    }

}
