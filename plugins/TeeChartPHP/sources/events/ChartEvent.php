<?php
  /**
 * Description:  This file contains the following class:<br>
 * ChartEvent class <br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */
 /**
 * ChartEvent class
 *
 * Description:
 *
 * @author Steema Software SL
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

class ChartEvent {

      // not sure if required static vars
      public static $CHART_FIRST;
      public static $CHART_ADDED;
      public static $CHART_SCROLLED;
      public static $CHART_UNZOOMED;
      public static $CHART_ZOOMED;
      public static $CHART_LAST;

      private $name;
      protected $source;

      function __construct($name) {

        // not sure if required static vars
        self::$CHART_FIRST    = 0; // AWTEvent.RESERVED_ID_MAX + 1;   temp 0
        self::$CHART_ADDED    = self::$CHART_FIRST;
        self::$CHART_SCROLLED = self::$CHART_FIRST + 1;
        self::$CHART_UNZOOMED = self::$CHART_FIRST + 2;
        self::$CHART_ZOOMED   = self::$CHART_FIRST + 3;
        self::$CHART_LAST     = self::$CHART_FIRST + 3;

  	    $this->source = $name;
        $this->name = $name;
  	}
    
    public function __destruct() {        
        unset($this->source);
        unset($this->name);
    }          

  	function getSource() {
  		return $this->source;
  	}

    public function GetName()
    {
         return $this->name;
    }

    /**
     * Creates a new instance of ChartEvent
     *
    public function ChartEvent($source, $id) {

      self::$CHART_FIRST    = 0; // AWTEvent.RESERVED_ID_MAX + 1;   temp 0
      self::$CHART_ADDED    = self::$CHART_FIRST;
      self::$CHART_SCROLLED = self::$CHART_FIRST + 1;
      self::$CHART_UNZOOMED = self::$CHART_FIRST + 2;
      self::$CHART_ZOOMED   = self::$CHART_FIRST + 3;
      self::$CHART_LAST     = self::$CHART_FIRST + 3;


        // super(source, id);
      $this->registerEventCallback($source);
    }

	  function registerEventCallback($callback) {
  		$this->callbacks[] = $callback;
  	}

  	function fireEvent() {
  		foreach ($this->callbacks as $callback) {
  			call_user_func($callback);
  		}
  	} */
}
?>