<?php
 /**
 * Description:  This file contains the following class:<br>
 * Tool class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * Tool class
 *
 * Description: Base Tool class
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

 class Tool extends TeeBase {

    public $clickTolerance = 3;

    protected $pPen=null; // $Delayed $creation $at $derived $getPen()
    protected $bBrush=null; // $Delayed $creation $at $derived $getBrush()
    private $active = true;

    protected $listenerList;

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

    protected function readResolve() {
        $this->listenerList = new EventListenerList();
        return $this;
    }

     function getFirstLastSeries($s) {
        $result = new GetFirstLast();

        $result->min = $s->getFirstVisible();
        if ($result->min < 0) {
            $result->min = 0;
        }

        $result->max = $s->getLastVisible();
        if ($result->max < 0) {
            $result->max = $s->getCount() - 1;
        } else
        if ($result->max >= $s->getCount()) {
            $result->max = $s->getCount() - 1; // 5.03
        }

        $result->result = ($s->getCount() > 0) && ($result->min <= $s->getCount()) &&
                        ($this->result->max <= $s->getCount());
        return $result;
    }

    public function __construct($c=null) {
        parent::__construct($c);
       
        if ($this->chart != null) {
            $this->chart->getTools()->internalAdd($this);
        }

        $this->readResolve();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->clickTolerance);
        unset($this->pPen);
        unset($this->bBrush);
        unset($this->active);
        unset($this->listenerList);
    }         

    public function toString() {
        return $this->getDescription();
    }

    /* TODO
    public function addMouseMotionListener($l) {
        $this->listenerList->add($this->MouseMotionListener->class, $l);
    }

    public function removeMouseMotionListener($l) {
        $this->listenerList->remove($this->MouseMotionListener->class, $l);
    }

    protected function fireMouse($e) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->MouseMotionListener->class) {
                $tmpMouseEvent = new MouseEvent();
                if ($e->getID()==$tmpMouseEvent->MOUSE_DRAGGED) {
                    (($this->MouseMotionListener) $this->listeners[$i + 1])->mouseDragged($e);
                } else if ($e->getID()==$tmpMouseEvent->MOUSE_MOVED) {
                    (($this->MouseMotionListener) $this->listeners[$i + 1])->mouseMoved($e);
                }
            }
            if ($this->listeners[$i] == $this->MouseListener->class) {

            }
        }
    }

    protected function fireChanged($ce) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->ChangeListener->class) {
              (($this->ChangeListener) $this->listeners[$i + 1])->stateChanged($ce);
            }
        }
    }

    protected function fireClicked($e) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->ToolMouseListener->class) {
              (($this->ToolMouseListener) $this->listeners[$i + 1])->toolClicked($e);
            }
        }
    }

    protected function fireDragged($e) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->DragListener->class) {
              (($this->DragListener) $this->listeners[$i + 1])->dragFinished($e);
            }
        }
    }

    protected function fireDragging($e) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->DragListener->class) {
              (($this->DragListener) $this->listeners[$i + 1])->dragMoving($e);
            }
        }
    }

    protected function fireResized($e) {
        $this->Object[] $this->listeners = $this->listenerList->getListenerList();
        for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
            if ($this->listeners[$i] == $this->SizeListener->class) {
              (($this->SizeListener) $this->listeners[$i + 1])->sizeChanged($e);
            }
        }
    }
    */

    /**
      * Enables/Disables the indexed Tool.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setActive($value) {
        $this->active = $this->setBooleanProperty($this->active, $value);
    }

    /**
      * Enables/Disables the indexed Tool.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getActive() {
        return $this->active;
    }

    public function setChart($value) {
        if (!($this->chart === $value)) {
            if ($this->chart != null) {
                $this->chart->getTools()->remove($this);
            }

            parent::setChart($value);

            if ($this->chart != null) {
                $this->chart->getTools()->add($this);
            }
            if ($this->pPen != null) {
                $this->pPen->setChart($this->chart);
            }
            if ($this->bBrush != null) {
                $this->bBrush->setChart($this->chart);
            }
            if ($this->chart != null) {
                $this->chart->invalidate();
            }
        }
    }

    public function chartEvent($ce) {}

    public function mouseEvent($e, $c) {
        $this->fireMouse($e);
        return $c;
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return "";
    }

    /**
      * Gets detailed descriptive text.
      *
      * @return String
      */
    public function getSummary() {
        return "";
    }

    /**
      * Returns the URL of the associated icon for a given Tool class.<br>
      * This icon is used at Tools gallery listbox and Tools Editor dialog.
      *
      * @return URL
      */
    public function getBitmapEditor() {
        $name = $this->getClass()->getName();
        $name = "icons/"+$name->substring($name->lastIndexOf('->')+1)+"->gif";
        return $this->Tool->class->getResource($name);
    }
}

/**
 * GetFirstLast class
 *
 * Description: GetFirstLast class
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
 class GetFirstLast {
        public $result;
        public $min;
        public $max;
}
?>