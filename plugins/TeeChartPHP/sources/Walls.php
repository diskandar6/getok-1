<?php
 /**
 * Description:  This file contains the following classes:<br>
 * Walls class<br>
 * LeftWall class <br>
 * RightWall class <br>
 * BackWall class <br>
 * BottomWall class <br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Walls class
 *
 * Description: Chart Walls. Accesses Wall and overall Wall
 * display characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Walls extends TeeBase {

    private $back;
    private $bottom;
    private $left;
    private $right;
    private $visible = true;
    private $view3D = true;

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

    /**
     * Defines the Pen and Brush used to fill the left chart side.<br>
     * Available IWall properties are Brush, Color, Dark3D, Gradient, Pen,
     * Size and Transparent.<br>
     * tChart.Aspect.View3D and tChart.Walls.Visible
     * should be true to use tChart.Walls.Back, tChart.Walls.Bottom,
     * tChart.Walls.Left and tChart.Walls.Right.
     *
     * @return LeftWall
     */
    public function getLeft() {
        return $this->left;
    }

    public function setLeft($value) {
        $this->left = $value;
    }

    /**
     * Defines the pen and brush used to fill the right chart side.<br>
     * Available IWall properties are Brush, Color, Dark3D, Gradient, Pen,
     * Size and Transparent.<br>
     * tChart.Aspect.View3D and tChart.Walls.Visible
     * should be true to use tChart.Walls.Back, tChart.Walls.Bottom,
     * tChart.Walls.Left and tChart.Walls.Right.
     *
     * @return RightWall
     */
    public function getRight() {
        return $this->right;
    }

    public function setRight($value) {
        $this->right = $value;
    }

    /**
     * Defines the pen and brush used to fill the back chart side.<br>
     * Available IWall properties are Brush, Color, Dark3D, Gradient, Pen,
     * Size and Transparent.<br>
     * tChart.Aspect.View3D and tChart.Walls.Visible
     * should be true to use tChart.Walls.Back, tChart.Walls.Bottom,
     * tChart.Walls.Left and tChart.Walls.Right.
     *
     * @return BackWall
     */
    public function getBack() {
        return $this->back;
    }

    public function setBack($value) {
        $this->back = $value;
    }

    /**
     * Defines the pen and brush used to fill the bottom chart side.<br>
     * Available IWall properties are Brush, Color, Dark3D, Gradient, Pen,
     * Size and Transparent.<br>
     * tChart.Aspect.View3D and tChart.Walls.Visible
     * should be true to use tChart.Walls.Back, tChart.Walls.Bottom,
     * tChart.Walls.Left and tChart.Walls.Right.
     *
     * @return BottomWall
     */
    public function getBottom() {
        return $this->bottom;
    }

    public function setBottom($value) {
        $this->bottom = $value;
    }

    /**
     * Shows / Hides all Chart walls.<br>
     * Visible draws Left and Bottom "walls" to simulate 3D effect.<br>
     * You can control the 3D Wall proportion by using
     * Chart.Aspect.Chart3DPercent.<br>
     * Chart.Aspect.View3D controls (on/off) Walls.Visible. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Shows / Hides all Chart walls.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    /**
     * Shows all Chart walls in 3D.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getView3D() {
        return $this->view3D;
    }

    /**
     * Shows all Chart walls in 3D when true.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setView3D($value) {
        $this->view3D = $this->setBooleanProperty($this->view3D, $value);
    }

    public function __construct($c) {
        parent::__construct($c);
               
        $this->left = new LeftWall($c, $this);
        $this->right = new RightWall($c, $this);
        $this->bottom = new BottomWall($c, $this);
        $this->back = new BackWall($c, $this);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();   
        unset($this->left);
        unset($this->right);
        unset($this->bottom);
        unset($this->back);
        unset($this->visible);
        unset($this->view3D);
    }      
    
    /**
     * Paints walls at rectangle r.
     *
     * @param g IGraphics3D
     * @param r Rectangle
     */
    public function paint($g, $r) {
       
        $old_name = TChart::$controlName;
        
        if ($this->back->getVisible()) {
            $this->back->paint($g, $r);
        }
        
        TChart::$controlName = $old_name;
        
        if ($this->chart->getAspect()->getView3D() && $this->visible) {
            if ($this->left->getVisible()) {
                $this->left->paint($g, $r);
            }
            
            TChart::$controlName = $old_name;
            
            if ($this->bottom->getVisible()) {
                $this->bottom->paint($g, $r);
            }
            
            TChart::$controlName = $old_name;
            
            if ($this->right->getVisible()) {
                $this->right->paint($g, $r);
            }
        }
    }

    /**
     * Calculates the Wall thickness of the specified Axis.
     *
     * @param a Axis
     * @return int
     */
    public function calcWallSize($a) {
        if ($this->chart->getAspect()->getView3D() && $this->getVisible()) {
            if ($a === $this->chart->getAxes()->getLeft()) {
                return $this->left->getSize();
            } else
            if ($a === $this->chart->getAxes()->getBottom()) {
                return $this->bottom->getSize();
            }
        }
        return 0;
    }

    public function setSize($value) {
        $this->getLeft()->setSize($value);
        $this->getRight()->setSize($value);
        $this->getBottom()->setSize($value);
        $this->getBack()->setSize($value);
    }

    public function setChart($value) {
        parent::setChart($value);

        $this->getLeft()->setChart($value);
        $this->getRight()->setChart($value);
        $this->getBottom()->setChart($value);
        $this->getBack()->setChart($value);
    }
}


/**
 * LeftWall class
 *
 * Description: Wall Panel at left of Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class LeftWall extends Wall {

    function __construct($c, $w) {
        parent::__construct($c);
        $this->getBrush()->setDefaultColor(new Color(255,255,128));
    }
    
    public function __destruct() {        
        parent::__destruct();   
    }      

    /**
     * Use this method to paint a left wall at rectangle r.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function paint($g, $rect) {
        
        TChart::$controlName .= 'LeftWall_';            
        
        $this->prepareGraphics($g);
        $tmpB = $rect->getBottom() +
                   $this->chart->getWalls()->calcWallSize($this->chart->getAxes()->getBottom());
        $w = $this->chart->getAspect()->getWidth3D();

        if ($this->iSize > 0) {
            $g->cube($rect->x - $this->iSize, $rect->y, $rect->x, $tmpB, 0, $w,
                   $this->getShouldDark());
        } else {
            $g->rectangleZ($rect->x, $rect->y, $tmpB, 0, $w);
        }
    }

    /**
     * The color used to fill the LeftWall background.<br>
     * Default value: LIGHT_YELLOW
     *
     *
     * @return Color
     */
    public function getColor() {
        return parent::getColor();
    }

    /**
     * Specifies the color used to fill the LeftWall background.<br>
     * Default value: LIGHT_YELLOW
     *
     *
     * @param value Color
     */
    public function setColor($value) {
        parent::setColor($value);
    }
}

 /**
 * RightWall class
 *
 * Description: Wall Panel at right of Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class RightWall extends Wall {

    function __construct($c, $w) {
        parent::__construct($c);
        $this->visible = false;
        $this->getBrush()->setDefaultColor(new Color(255,255,128));
    }
    
    public function __destruct() {        
        parent::__destruct();   
    }      
    

    /**
     * Use this method to paint a right wall at rectangle r.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function paint($g, $rect) {
        TChart::$controlName .= 'RightWall_';            
        
        $this->prepareGraphics($g);

        $b = $rect->getBottom() + $this->chart->getWalls()->calcWallSize($this->chart->getAxes()->getBottom());
        $w = $this->chart->getAspect()->getWidth3D();

        if ($this->iSize > 0) {
            $g->cube($rect->getRight(), $rect->y, $rect->getRight() + $this->iSize, $b, 0,
                   $w + $this->getBack()->getSize(), $this->getShouldDark());
        } else {
            $g->rectangleZ($rect->getRight(), $rect->y, $b, 0, $w + 1);
        }
    }

    /**
     * Shows/Hides Right Wall.<br>
     * Default value: false
     *
     * @return boolean
     */
    public function getVisible() {
        return parent::getVisible();
    }

    /**
     * Shows/Hides Right Wall.<br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setVisible($value) {
        parent::setVisible($value);
    }
}

 /**
 * BackWall class
 *
 * Description: Wall Panel at rear of Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class BackWall extends Wall {

    function __construct($c, $w) {
        parent::__construct($c);
        $this->getBrush()->setDefaultColor(new Color(255,255,128));
        $this->bTransparent = false;
    }

    public function __destruct() {        
        parent::__destruct();   
    }      
    
    /**
     * Use this method to paint a back wall at rectangle r.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function paint($g, $rect) {
        TChart::$controlName .= 'BackWall_';            
        
        $this->prepareGraphics($g);

        if ($this->chart->getAspect()->getView3D()) {
            $w = $this->chart->getAspect()->getWidth3D();
            if ($this->iSize > 0) {
                $r = $rect;
                $s = $this->chart->getWalls()->calcWallSize($this->chart->getAxes()->getLeft());
                $r->x -= $s;
                $r->width += $s;
                $r->height += $this->chart->getWalls()->calcWallSize($this->chart->getAxes()->getBottom());
                $g->cube($r->getLeft(), $r->getTop(), $r->getRight(),$r->getBottom(), $w, $w + $this->iSize, $this->getShouldDark());
            } else {
                $g->rectangleWithZ($rect, $w);
            }
        } else {
            $g->rectangle($rect);
        }
    }

    protected function shouldSerializeTransparent() {
        return !$this->getTransparent();
    }
}

 /**
 * BottomWall class
 *
 * Description: Wall Panel at bottom of Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class BottomWall extends Wall {

    function __construct($c, $w) {
        parent::__construct($c);
        $this->setColor(new Color(255,255,255));
    }

    public function __destruct() {        
        parent::__destruct();   
    }      
    
    /**
     * Use this method to paint a bottom wall at rectangle r.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function paint($g, $rect) {
        
        TChart::$controlName .= 'BottomWall_';
        
        $this->prepareGraphics($g);        

        $w = $this->chart->getAspect()->getWidth3D();
        if ($this->iSize > 0) {
            $r = $rect->copy();
            $r->y = $r->getBottom();
            $r->height = $this->iSize;                
            $g->cuber($r, 0, $w, $this->getShouldDark());
        } else {
            $g->rectangleY($rect->x, $rect->getBottom(), $rect->getRight(), 0, $w);
        }
    }
}
?>
