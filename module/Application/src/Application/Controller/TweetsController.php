<?php
/**
 * File contains class TweetsController
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\Controller;

use Application\Entity\Tweet;
use Application\Form\SearchForm;
use Application\Service\HistoryTracker;
use Application\Twitter\Api\Search\SearchApiInterface;
use Application\Twitter\Api\Search\SearchApiParams;
use Zend\Form\FormElementManager;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
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
        /** @var Request $request */
        $request = $this->getRequest();

        $form = $this->getSearchForm();
        $form->setData($request->getQuery());

        $viewModel->setVariable('form', $form);

        return $viewModel;
    }

    public function searchAction()
    {
        /** @var Request $request */
        $request  = $this->getRequest();
        $response = new Response();

        if (!$request->isXmlHttpRequest()) {
            $response->setStatusCode(400);

            return $response;
        }

        if (!$request->isPost()) {
            $response->setStatusCode(400);

            return $response;
        }

        /** @var SearchApiParams $params */
        $params = $this->getServiceLocator()->get('twitter.api.search.params');
        /** @var SearchApiInterface $api */
        $api = $this->getServiceLocator()->get('twitter.api.search');

        $params    = $params->fromRequest($request->getPost()->toArray());
        $tweets    = $api->tweets($params, SearchApiInterface::HYDRATE_ARRAY);
        $viewModel = new JsonModel(['tweets' => $tweets]);

        return $viewModel;
    }

    public function historyAction()
    {
        $history = $this->getHistoryTracker()->findRecent();

        return new ViewModel(['history' => $history]);
    }

    public function trackAction()
    {
        /** @var Request $request */
        $request  = $this->getRequest();
        $response = new Response();

        if (!$request->isXmlHttpRequest()) {
            $response->setStatusCode(400);

            return $response;
        }

        if (!$query = $request->getPost('q')) {
            $response->setStatusCode(400);

            return $response;
        }

        $this->getHistoryTracker()->save($query);

        $response->setStatusCode(202);

        return $response;
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

    /**
     * @return HistoryTracker
     */
    private function getHistoryTracker()
    {
        return $this->getServiceLocator()->get('app.service.history-tracker');
    }
}