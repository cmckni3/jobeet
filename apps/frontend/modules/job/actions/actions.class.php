<?php

/**
 * job actions.
 *
 * @package    jobeet
 * @subpackage job
 * @author     Your name here
 */
class jobActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->jobeet_jobs = JobeetJobQuery::create()->find();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->job = JobeetJobPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->job);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new JobeetJobForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $JobeetJob = JobeetJobQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetJob, sprintf('Object JobeetJob does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetJobForm($JobeetJob);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $JobeetJob = JobeetJobQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetJob, sprintf('Object JobeetJob does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetJobForm($JobeetJob);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $JobeetJob = JobeetJobQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetJob, sprintf('Object JobeetJob does not exist (%s).', $request->getParameter('id')));
    $JobeetJob->delete();

    $this->redirect('job/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $JobeetJob = $form->save();

      $this->redirect('job/edit?id='.$JobeetJob->getId());
    }
  }
}
