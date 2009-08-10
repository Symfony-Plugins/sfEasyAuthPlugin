<?php
// only declare this class if the user hasn't created it already
if (!class_exists('sfWidgetFormSchemaFormatterDiv'))
{
  class sfWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter 
  {
    protected
      $rowFormat = '%error%%field%<br />%help%<br />',
      $helpFormat = '<span class="help">%help%</span>',
      $errorRowFormat = '<div>%errors%</div>',
      $errorListFormatInARow = '%errors%',
      $errorRowFormatInARow = '<div class="formError">&darr;&nbsp;%error%&nbsp;&darr;</div>',
      $namedErrorRowFormatInARow = '%name%: %error%<br />',
      $decoratorFormat = '<div id="formContainer">%content%</div>';
  }
}