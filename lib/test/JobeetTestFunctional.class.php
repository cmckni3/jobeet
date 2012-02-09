<?php

class JobeetTestFunctional extends sfTestFunctional
{
  public function loadData()
  {
    $loader = new sfPropelData();
    $loader->loadData(sfConfig::get('sf_test_dir').'/fixtures');
 
    return $this;
  }
  
  public function getMostRecentProgrammingJob()
  {
    // most recent job in the programming category
    $category = JobeetCategoryPeer::getForSlug('programming');
 
    $criteria = new Criteria();
    $criteria->add(JobeetJobPeer::EXPIRES_AT, time(), Criteria::GREATER_THAN);
    $criteria->add(JobeetJobPeer::CATEGORY_ID, $category->getId());
    $criteria->addDescendingOrderByColumn(JobeetJobPeer::CREATED_AT);
 
    return JobeetJobPeer::doSelectOne($criteria);
  }
  
  public function getExpiredJob()
  {
    // expired job
    $criteria = new Criteria();
    $criteria->add(JobeetJobPeer::EXPIRES_AT, time(), Criteria::LESS_THAN);
 
    return JobeetJobPeer::doSelectOne($criteria);
  }
  
  public function createJob($values = array(), $publish = false)
  {
    $this->
      get('/job/new')->
      click('Preview your job', array('job' => array_merge(array(
        'company'      => 'Sensio Labs',
        'url'          => 'http://www.sensio.com/',
        'position'     => 'Developer',
        'location'     => 'Atlanta, USA',
        'description'  => 'You will work with symfony to develop websites for our customers.',
        'how_to_apply' => 'Send me an email',
        'email'        => 'for.a.job@example.com',
        'is_public'    => false,
      ), $values)))->
      followRedirect()
    ;
 
    if ($publish)
    {
      $this->
        click('Publish', array(), array('method' => 'put', '_with_csrf' => true))->
        followRedirect()
      ;
    }
 
    return $this;
  }
 
  public function getJobByPosition($position)
  {
    $criteria = new Criteria();
    $criteria->add(JobeetJobPeer::POSITION, $position);
 
    return JobeetJobPeer::doSelectOne($criteria);
  }
  
  public function getProgrammingCategory()
  {
    return JobeetCategoryPeer::getForSlug('programming');
  }
}