<?php

/**
 * affiliate actions.
 *
 * @package    jobeet
 * @subpackage affiliate
 * @author     Your name here
 */
class affiliateActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->JobeetAffiliates = JobeetAffiliateQuery::create()->find();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new JobeetAffiliateForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new JobeetAffiliateForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $JobeetAffiliate = JobeetAffiliateQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetAffiliate, sprintf('Object JobeetAffiliate does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetAffiliateForm($JobeetAffiliate);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $JobeetAffiliate = JobeetAffiliateQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetAffiliate, sprintf('Object JobeetAffiliate does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetAffiliateForm($JobeetAffiliate);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $JobeetAffiliate = JobeetAffiliateQuery::create()->findPk($request->getParameter('id'));
    $this->forward404Unless($JobeetAffiliate, sprintf('Object JobeetAffiliate does not exist (%s).', $request->getParameter('id')));
    $JobeetAffiliate->delete();

    $this->redirect('affiliate/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $jobeet_affiliate = $form->save();

      $this->redirect($this->generateUrl('affiliate_wait', $jobeet_affiliate));
    }
  }
  
  public function executeWait(sfWebRequest $request)
  {
  }
  
}
