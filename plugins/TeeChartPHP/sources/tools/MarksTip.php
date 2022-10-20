<?php
 /**
 * Description:  This file contains the following class:<br>
 * MarksTip class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
  * <p>Title: MarksTip class</p>
  *
  * <p>Description: Marks Tip.<br>
  * Marks tip tool, use it to display "tips" or "hints" when the end-user moves
  * or clicks the mouse over a series point.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
  
 class MarksTip extends ToolSeries {

    //private $mouseAction = $MarksTipMouseAction.MOVE;
    
    private $style = 2; // MarksStyle::$LABEL;
    protected $customToolTip;    

    public function __construct($c=null) {
        parent::__construct($c);
        
        $this->readResolve();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->style);
        unset($this->customToolTip);
    }        

    protected function readResolve() {
        //$tmpDefaultResolvers = new DefaultResolvers();
        //$this->customToolTip = $tmpDefaultResolvers->TEXT_RESOLVER;
        return parent::readResolve();
    }

    public function setToolTipResolver($resolver) {
        if ($resolver != null) {
            $this->customToolTip = $resolver;
        } else {
            $this->removeToolTipResolver();
        }
    }

    public function removeToolTipResolver() {
    //    $tmpDefaultResolvers = new DefaultResolvers();
    //    $this->customToolTip = $tmpDefaultResolvers->TEXT_RESOLVER;
    }

    /**
    * Defines the text format of the Mark ToolTip.<br>
    * Default value: MarksStyle.Label
    *
    *
    * @return MarksStyle
    */
    public function getStyle() {
        return $this->style;
    }

    /**
    * Defines the text format of the Mark ToolTip.<br>
    * Default value: MarksStyle.Label
    *
    *
    * @param value MarksStyle
    */
    public function setStyle($value) {
        if ($this->style != $value) {
            $this->style = $value;
            $this->invalidate();
        }
    }

    /**
    * Activates Mark Tip on mouse move or click.<br>
    * Default value: MarksTipMouseAction.Move
    *
    * @return MarksTipMouseAction
    */
    public function getMouseAction() {
        return $this->mouseAction;
    }

    /**
    * Activates Mark Tip on mouse move or click.<br>
    * Default value: MarksTipMouseAction.Move
    *
    * @param value MarksTipMouseAction
    */
    public function setMouseAction($value) {
        $this->mouseAction = $value;
        $this->chart->getToolTip()->setText(null);
    }

    /**
    * The time lag before the Tool Tip appears.<br>
    * Default value: 500
    *
    * @return int
    */
    public function getMouseDelay() {
        if ($this->chart==null) {
            return 0;
        } else {
             $tmp = $this->chart->getToolTip();
            return ($tmp==null) ? 0 : $tmp->getInitialDelay();
        }
    }

    /**
    * Sets the time lag before the Tool Tip appears.<br>
    * Default value: 500
    *
    * @param value int
    */
    public function setMouseDelay($value) {
        if ($this->chart!=null) {
            if ($this->chart->getToolTip()!=null) {
                $this->chart->getToolTip()->setInitialDelay($value);
            }
        }
    }
        
    /**
    * The time period during which the Tool Tip appears.<br>
    * Default value: 4000 (ms)
    *
    * @return int
    */
    public function getHideDelay() {
        if ($this->chart==null) {
            return 0;
        } else {
             $tmp = $this->chart->getToolTip();
            return ($tmp==null) ? 0 : $tmp->getDismissDelay();
        }
    }

    /**
    * Sets the time period during which the Tool Tip appears.<br>
    * Default value: 4000 (ms)
    *
    * @param value int
    */
    public function setHideDelay($value) {
        if ($this->chart!=null) {
            if ($this->chart->getToolTip()!=null) {
                $this->chart->getToolTip()->setDismissDelay($value);
            }
        }
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("MarksTipTool");
    }

    /**
    * Gets detailed descriptive text.
    *
    * @return String
    */
    public function getSummary() {
        return Language::getString("MarksTipSummary");
    }

    private function findClickedSeries($p) {
        $tmp=new FindClicked();

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            $tmp->series = $this->chart->getSeries($t);
            $tmp->index = $tmp->series->clicked($p);
            if ($tmp->index != -1) {
                return $tmp;
            }
        }

        // no series
        $tmp->series = null;
        $tmp->index = -1;
        return $tmp;
    }
   
    public function mouseEvent($e, $c) {

        $c = parent::mouseEvent($e, $c);

        if ((($this->getMouseAction() == MarksTipMouseAction::$MOVE) &&
             ($e->getID() == MouseEvent::$MOUSE_MOVED)) ||
            (($this->getMouseAction() == MarksTipMouseAction::$CLICK) &&
             ($e->getID() == MouseEvent::$MOUSE_PRESSED))) {
             $tmpSeries = null;
             $tmp = -1;

            // find which series is under XY
            if ($this->iSeries != null) {
                $tmpSeries = $this->iSeries;
                $tmp = $tmpSeries->clicked($e->getPoint());
            } else {
                 $tmp2 = $this->findClickedSeries($e->getPoint()); /* 5.02 */
                $tmpSeries = $tmp2->series;
                $tmp = $tmp2->index;
            }

            // if not ok, cancel hint...
            if ($tmp == -1) {

                 $tmpCancel = true;

                //* do not cancel if other MarkTipTools exist...
                 for ($tt = 0; $tt < sizeof($this->chart->getTools()); $tt++) {
                     $t = $this->chart->getTools()->getTool($tt);
                     if (($t != $this) && ($t instanceof MarksTip)) {
                         /* 5.01 */
                         $tmpCancel = false;
                         break;
                     }
                 }

                if ($tmpCancel) {
                    $this->chart->getToolTip()->setText(null);
                }
            } else {
                // show hint !
                $tmpStyle = $tmpSeries->getMarks()->getStyle();
                $tmpOld = $this->chart->getAutoRepaint();
                $this->chart->setAutoRepaint(false);
                $tmpSeries->getMarks()->etStyle($style);

                $tmpText = $tmpSeries->getValueMarkText($tmp);

                $tmpText = $this->customToolTip->getText($this,$tmpText);

                if (! $this->chart->getToolTip()->getText()->equals($tmpText)) {
                    // chart.ShowHint=True; /* 5.02 */
                    $this->chart->getToolTip()->setText($tmpText);
                }
                $tmpSeries->getMarks()->setStyle($tmpStyle);
                $this->chart->setAutoRepaint($tmpOld);
            }
        }

        return $c;
    }

    public function setActive($value) {
        parent::setActive($value);
        //super.setActive(value);
        if (!$this->getActive()) {
            $this->chart->getToolTip()->setText(null);
        }
    }
}
/**
  * <p>Title: FindClicked class</p>
  *
  * <p>Description: Marks Tip. Internal use olny<br>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
class FindClicked {
    private $series;
    private $index;
}
?>