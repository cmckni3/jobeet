<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(10);

$t->comment('example of using pass which is a test that always passes');
$t->pass('This test always passes.');

$t->comment('::slugify()');
$t->is(Jobeet::slugify('Sensio'), 'sensio', '::slugify() converts all characters to lower case');
$t->is(Jobeet::slugify('sensio labs'), 'sensio-labs', '::slugify() replaces a white space by a -');
$t->is(Jobeet::slugify('sensio   labs'), 'sensio-labs', '::slugify() replaces several white spaces by a single -');
$t->is(Jobeet::slugify('  sensio'), 'sensio', '::slugify() removes - at the beginning of a string');
$t->is(Jobeet::slugify('sensio  '), 'sensio', '::slugify() removes - at the end of a string');
$t->is(Jobeet::slugify('paris,france'), 'paris-france', '::slugify() replaces non-ASCII characters by a -');
$t->is(Jobeet::slugify(''), 'n-a', '::slugify() converts the empty string to n-a');
$t->is(Jobeet::slugify(' - '), 'n-a', '::slugify() converts a string that only contains non-ASCII characters to n-a');
if (function_exists('iconv'))
{
  $t->is(Jobeet::slugify('DŽveloppeur Web'), 'developpeur-web', '::slugify() removes accents');
}
else
{
  $t->skip('::slugify() removes accents - iconv not installed');
}