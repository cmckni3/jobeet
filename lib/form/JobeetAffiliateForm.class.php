<?php

/**
 * JobeetAffiliate form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 */
class JobeetAffiliateForm extends BaseJobeetAffiliateForm
{
  public function configure()
  {
    $this->useFields(array(
      'url', 
      'email', 
      'jobeet_category_affiliate_list'
    ));
    $this->widgetSchema['jobeet_category_affiliate_list']->setOption('expanded', true);
            $this->widgetSchema['jobeet_category_affiliate_list']->setLabel('Categories');
 
    $this->validatorSchema['jobeet_category_affiliate_list']->setOption('required', true);
 
    $this->widgetSchema['url']->setLabel('Your website URL');
    $this->widgetSchema['url']->setAttribute('size', 50);
 
    $this->widgetSchema['email']->setAttribute('size', 50);
 
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => true));
  }
}
