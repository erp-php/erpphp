<?php 

namespace Core\Service\Auth;

use Core\Service\CoreService;
use Zend\Authentication\AuthenticationService;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Authentication\Adapter\ObjectRepository as DoctrineAdapter;

class Auth extends CoreService
{
	
	/**
	 * Faz a autenticação dos usuários
	 *
	 * @param array $params
	 * @return array
	 */
	public function authenticate($params)
	{
		if (!isset($params['userName']) || !isset($params['password'])) {
			throw new \Exception("Parâmetros inválidos");
		}
		
		$password = sha1(md5($params['password']));
		
		$entityManager = $this->getEntityManager();
		
		$adapter = new DoctrineAdapter(array(
		    'objectManager' => $entityManager,
            'identityClass' => 'Core\Entity\System\Users',
            'identityProperty' => 'userName',
            'credentialProperty' => 'password',
            
		));
		
		$adapter->setIdentityValue(($params['userName']));
		$adapter->setCredentialValue($password);
		
		$authService = new AuthenticationService();
		$authService->setAdapter($adapter);
		
		
		$authResult = $authService->authenticate();
		
		
	
		if (! $authResult->isValid()) {
			throw new \Exception("Login ou senha inválidos");
		}else{
	
		$user = $this->getEntityManager()->getRepository('Core\Entity\Sistem\Users')
		    ->findOneBy(array(
		        'userName' => $params['userName'],
		        'password' => $password
		    ));
		$session = $this->getServiceManager()->get('Session');
		$session->offsetSet('sysUserData',$user);
		return true;
		}
	
		
	}
	
	/**
	 * Faz o logout do sistema
	 *
	 * @return void
	 */
	public function logout() {
		$auth = new AuthenticationService();
		$session = $this->getServiceManager()->get('Session');
		$session->offsetUnset('sysUserData');
		$auth->clearIdentity();
		return true;
	}
	
	/**
	 * Faz a autorização do usuário para acessar o recurso
	 * @param string $moduleName Nome do módulo sendo acessado
	 * @param string $controllerName Nome do controller
	 * @param string $actionName Nome da ação
	 * @return boolean
	 */
	public function authorize($moduleName, $controllerName, $actionName)
	{
	     
		$auth = new AuthenticationService();
		$role = 'visitante';
		if ($auth->hasIdentity()) {
			$session = $this->getServiceManager()->get('Session');
			$user = $session->offsetGet('sysUserData');
			$role = $user->role;
		}
	
		$resource = $controllerName . '.' . $actionName;
		$acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
		if ($acl->isAllowed($role, $resource)) {
			return true;
		}
		return false;
	}
	
	
	
	
}
	

	
