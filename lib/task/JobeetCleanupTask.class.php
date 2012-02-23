<?php

// lib/task/JobeetCleanupTask.class.php
class JobeetCleanupTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environement', 'prod'),
      new sfCommandOption('days', null, sfCommandOption::PARAMETER_REQUIRED, '', 90),
    ));
 
    $this->namespace = 'jobeet';
    $this->name = 'cleanup';
    $this->briefDescription = 'Cleanup Jobeet database';
 
    $this->detailedDescription = <<<EOF
The [jobeet:cleanup|INFO] task cleans up the Jobeet database:
 
  [./symfony jobeet:cleanup --env=prod --days=90|INFO]
EOF;
  }
  
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
   
    // cleanup Lucene index
    $index = JobeetJobPeer::getLuceneIndex();
   
    $criteria = new Criteria();
    $criteria->add(JobeetJobPeer::EXPIRES_AT, time(), Criteria::LESS_THAN);
    $jobs = JobeetJobPeer::doSelect($criteria);
    foreach ($jobs as $job)
    {
      if ($hit = $index->find('pk:'.$job->getId()))
      {
        $index->delete($hit->id);
      }
    }
   
    $index->optimize();
   
    $this->logSection('lucene', 'Cleaned up and optimized the job index');
   
    // Remove stale jobs
    $nb = JobeetJobPeer::cleanup($options['days']);
   
    $this->logSection('propel', sprintf('Removed %d stale jobs', $nb));
  }

}