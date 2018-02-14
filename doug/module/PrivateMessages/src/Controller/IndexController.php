<?php
namespace PrivateMessages\Controller;

use Login\Model\User;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Traits\BlockCipherTrait;
use PrivateMessages\Model\ {Message, MessagesTable};

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{

    //use SessionTrait;

    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const SEND_SUCCESS   = '<b style="color:green;">Message sent successfully</b>';
    const SEND_FAIL      = '<b style="color:red;">Unable to send message</b>';
    const SEND_START     = '<b style="color:gray;">Press "SEND" when ready to send a new message</b>';

    protected $table;
    protected $sendForm;
    protected $authService;
    protected $message;

    public function indexAction()
    {
        //*** assign the authenticated identity from the authentication service to $user
        //*** (see the Login module)
        $user = $this->authService->getIdentity();
        //*** Access Control (i.e. who gets to send private messages) will be handled in the CROSS CUTTING CONCERNS::ACCESS CONTROL LAB
        $from = $this->sendForm->get('fromEmail');
        $from->setAttribute('value', $user->getEmail());
        //*** to use this plugin, install it: "composer require zendframework/zend-mvc-plugin-flashmessenger"
        $status = $this->flashMessenger()->getMessages();
        return $this->setViewModel($user, $status);
    }
    public function sendAction()
    {
        //*** assign the authenticated identity from the authentication service to $user
        //*** (see the Login module)
        $user = $this->authService->getIdentity();
        //*** Access Control (i.e. who gets to send private messages) will be handled in the CROSS CUTTING CONCERNS::ACCESS CONTROL LAB
        $status = self::SEND_START;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->sendForm->bind(new Message());
            $this->sendForm->setData($request->getPost());
            if (!$this->sendForm->isValid()) {
                $status = self::FORM_INVALID;
            } else {
                $message = $this->sendForm->getData();
                if ($this->table->save($message)) {
                    $status = self::SEND_SUCCESS;
                    $this->redirect()->toRoute('messages');
                } else {
                    $status = self::SEND_FAIL . '<br>' . implode('<br>', $result->getMessages());
                }
            }
        }
        //*** to use this plugin, install it: "composer require zendframework/zend-mvc-plugin-flashmessenger"
        $this->flashMessenger()->addMessage($status);
        return $this->setViewModel($user, $status);
    }
    protected function setViewModel($user, $status)
    {
        $htmlStatus = '';
        if ($status) {
            $htmlStatus .= '<ul>';
            if (is_array($status)) {
                $htmlStatus .= '<li>' . implode('</li><li>', $status) . '</li>';
            } else {
                $htmlStatus .= '<li>' . $status . '</li>';
            }
            $htmlStatus .= '</ul>';
        }
        $viewModel = new ViewModel(
            [
                'identity' => $user,
                'sendForm' => $this->sendForm,
                'sentMessages' => $this->table->findMessagesSent($user->getEmail()),
                'receivedMessages' => $this->table->findMessagesReceived($user->getEmail()),
                'status' => $htmlStatus,
                //*** ADVANCED VIEW::I18N LAB: assign locale to the view
            ]
        );
        $viewModel->setTemplate('private-messages/index/index');
        return $viewModel;
    }
    public function setTable(MessagesTable $table)
    {
        $this->table = $table;
    }
    public function setSendForm(SendForm $form)
    {
        $this->sendForm = $form;
    }
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
    }
}
