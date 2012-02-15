<?php

require_once dirname(__FILE__).'/../lib/affiliateGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/affiliateGeneratorHelper.class.php';

/**
 * affiliate actions.
 *
 * @package    jobeet
 * @subpackage affiliate
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class affiliateActions extends autoAffiliateActions
{
public function executeListActivate()
  {
    $affiliate = $this->getRoute()->getObject();
    $affiliate->activate();
 
    // send an email to the affiliate
    $message = $this->getMailer()->compose(
      array('cmckni3@gmail.com' => 'Jobeet Bot'),
      $affiliate->getEmail(),
      'Jobeet affiliate token',
      <<<EOF
Your Jobeet affiliate account has been activated.
 
Your token is {$affiliate->getToken()}.
 
The Jobeet Bot.
EOF
    );
 
    $this->getMailer()->send($message);
 
    $this->redirect('jobeet_affiliate');
  }
   
  public function executeListDeactivate()
  {
    $this->getRoute()->getObject()->deactivate();
 
    $this->redirect('jobeet_affiliate');
  }
 
  public function executeBatchActivate(sfWebRequest $request)
  {
    $affiliates = JobeetAffiliatePeer::retrieveByPks($request->getParameter('ids'));
 
    foreach ($affiliates as $affiliate)
    {
      $affiliate->activate();
    }
 
    $this->redirect('jobeet_affiliate');
  }
 
  public function executeBatchDeactivate(sfWebRequest $request)
  {
    $affiliates = JobeetAffiliatePeer::retrieveByPks($request->getParameter('ids'));
 
    foreach ($affiliates as $affiliate)
    {
      $affiliate->deactivate();
    }
 
    $this->redirect('jobeet_affiliate');
  }
  
}
