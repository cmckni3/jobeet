<?php use_stylesheet('jobs.css') ?>
<?php error_log(print_r($jobs, true)); ?>
<div id="jobs">
  <?php include_partial('job/list', array('jobs' => $jobs)) ?>
</div>