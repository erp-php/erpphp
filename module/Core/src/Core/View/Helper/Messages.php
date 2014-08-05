<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Messages extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $type;
    private $message;
    private $closeButton;

    /**
     * Set the service locator.
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }
    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Retorna a mensagem renderizada
     * @param string $type
     * @param string $message
     * @param string $closeButton
     */
    public function __invoke($message,$type = 'normal', $closeButton = true)
    {
        $this->setType($type);
        $this->setMessage($message);
        $this->setCloseButton($closeButton);

        return $this->render();
    }

    protected function getType()
    {
        return $this->type;
    }

    protected function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    protected function getMessage()
    {
        return $this->message;
    }

    protected function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    protected function getCloseButton()
    {
        return $this->closeButton;
    }

    protected function setCloseButton($closeButton)
    {
        $this->closeButton = $closeButton;

        return $this;
    }

    protected function render()
    {
        $type = $this->getRealType($this->getType());
        $html = "<div class=\"alert $type\">";
        if ($this->getCloseButton()) {
            $html.= "<button class=\"close\" data-dismiss=\"alert\"></button>";
        }
        $html.= $this->getMessage();
        $html.= "</div>";

        return $html;

    }

    protected function getRealType($type)
    {
        switch ($type) {
            case 'success':
               return 'alert-success';
            break;

            case 'error':
                return 'alert-error';
            break;

            case 'info':
                return 'alert-info';
            break;

            default:
                return '';
            break;
        }

    }

}
