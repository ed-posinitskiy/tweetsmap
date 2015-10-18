<?php
/**
 * File contains class TweetsController
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\Controller;

use Application\Form\SearchForm;
use Application\Service\HistoryTracker;
use Zend\Form\FormElementManager;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class TweetsController
 *
 * @package Application\Controller
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
class TweetsController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $this->getSearchForm());

        return $viewModel;
    }

    public function searchAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $query   = $request->getQuery('q');

        if (!$request->isXmlHttpRequest()) {
            $redirectUrl = $this->url()->fromRoute('tweets');
            if (!empty($query)) {
                $redirectUrl .= '?q=' . $query;
            }

            return $this->redirect()->toUrl($redirectUrl);
        }

        /** @var HistoryTracker $tracker */
        $tracker = $this->getServiceLocator()->get('app.service.history-tracker');
        $tracker->save($query);


    }

    public function historyAction()
    {

    }

    /**
     * @return SearchForm
     */
    private function getSearchForm()
    {
        /** @var FormElementManager $manager */
        $manager = $this->getServiceLocator()->get('FormElementManager');

        return $manager->get('tweets.form.search');
    }
}