<?php

namespace Futjikato\PageFreeze\Controller;

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;
use TYPO3\Flow\Security\Context as SecurityContext;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Service\ContextFactoryInterface;

class BackendController extends \TYPO3\Flow\Mvc\Controller\ActionController
{
    /**
     * @var ContextFactoryInterface
     * @Flow\Inject
     */
    protected $contextFactory;

    /**
     * @var PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;

    /**
     * @var SecurityContext
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * @return void
     */
    public function indexAction()
    {
        $ctx = $this->contextFactory->create(array(
            'workspaceName' => 'live'
        ));
        $root = $ctx->getRootNode();

        $flowQuery = new FlowQuery(array($root));
        $flowQuery = $flowQuery->find('[instanceof Futjikato.PageFreeze:FreezableMixin][pageFreeze = TRUE]');
        $nodes = $flowQuery->get();

        $this->view->assign('siteNode', $root);
        $this->view->assign('frozenNodes', $nodes);
    }

    /**
     * @param NodeInterface $node
     *
     * @return void
     */
    public function unfreezeAction(NodeInterface $node)
    {
        if (!$node->hasProperty('pageFreeze')) {
            $this->addFlashMessage('Unable to perform action. Invalid node.', '', Message::SEVERITY_ERROR);
            $this->redirect('index');
        }

        $persistenceManager = $this->persistenceManager;
        $this->securityContext->withoutAuthorizationChecks(function() use ($node, $persistenceManager) {
            $node->setProperty('pageFreeze', false);
            $persistenceManager->persistAll();
        });

        $this->addFlashMessage('Removed page from archive.', '', Message::SEVERITY_OK);
        $this->redirect('index');
    }
}
