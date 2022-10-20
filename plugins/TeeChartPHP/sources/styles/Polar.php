<?php
 /**
 * Description:  This file contains the following class:<br>
 * Polar class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Polar class</p>
  *
  * <p>Description: Polar Series.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 class Polar extends CustomPolar {

    public function __construct($c=null) {
        parent::__construct($c);
    }

    protected function addSampleValues($numValues) {
        $tmp = 360.0 / $numValues;
        $r = $this->randomBounds($numValues);
        for ( $t = 1; $t <= $numValues; $t++) {
            $this->addXY($t * $tmp, // Angle
                1 + (1000 * $r->Random())); // Value (Radius)
        }
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GalleryPolar");
    }
}
?>