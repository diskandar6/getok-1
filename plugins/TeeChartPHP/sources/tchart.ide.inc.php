<?php
/**
 *  This file is part of Steema Software
 *  It generates the design time TChart component.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 *  This file is part of Steema Software
 *  It generates the design time TChart component.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

  require_once("vcl/vcl.inc.php");
  use_unit("designide.inc.php");


/**
 *  Component editor for the TChartObj component
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
  class TChartObjEditor extends ComponentEditor
  {
      function getVerbs()
      {
            // echo "Edit...\n";
            echo "About...\n";
      }

      function executeVerb($verb)
      {
          switch($verb)
          {
            case 0:
				      echo "TeeChart for PHP v 1.1 Component. ,\n";
				      echo "Copyright (c) 2010 Steema Software.\n";
              echo "All Rights Reserved.\n";
              break;
            }
      }    
  }
?>