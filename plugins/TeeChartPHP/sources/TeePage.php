<?php
 /**
 * Description:  This file contains the following class:<br>
 * Page class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Page class
 *
 * Description: Chart paging characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeePage extends TeeBase {

    private $maxPoints = 0;
    private $current = 1;
    private $scaleLast = true;

    protected $changeEvent;

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

    /** A list of event listeners for this component. */
    protected $listenerList;

    /**
    * The class constructor.
    */
    public function __construct($c) {
        parent::__construct($c);
        $this->readResolve();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();
       
        unset($this->maxPoints);
        unset($this->current);
        unset($this->scaleLast);
        unset($this->changeEvent);
    }          

    protected function readResolve() {
        return $this;
    }

    /**
     * Gets the number of pages, according to MaxPointsPerPage property.<br>
     * TChart.Page.MaxPointsPerPage must be greater than zero to activate auto
     * paging. TChart.Page.Current determines the current visible page.
     *
     * @return number of Chart pages
     */
    public function getCount() {
        return $this->chart->getNumPages();
    }

    /**
     * The current page number.<br><br>
     *
     * Run-time only.
     * TChart.Page.Current determines the current visible points of Series in
     * a Chart with MaxPointsPerPage greater than zero.
     * When TChart.Page.MaxPointsPerPage is greater than zero, TeeChart
     * internally divides all Series points in "pages".
     * Each page is assigned a different initial and ending X coordinates.
     * TChart.Page.NumPages returns the total number of pages. It equals the
     * total number of Series points divided by MaxPointsPerPage.
     * TChart.Page.Previous and TChart.Page.Next decrement or increment
     * Current respectively.
     *
     * @return current page number
     */
    public function getCurrent() {
        return $this->current;
    }

    /**
     * Sets the current page number.
     *
     * @param value int
     */
    public function setCurrent($value) {
        if (($value >= 0) && ($value <= $this->getCount())) {
            $this->current = $this->setIntegerProperty($this->current, $value);
        }
    }

    /**
     * The number of points displayed per page.<br>
     * Default value: 0
     *
     * @return maximum number of points
     */
    public function getMaxPointsPerPage() {
        return $this->maxPoints;
    }

    /**
     * Sets the number of points displayed per page.<br>
     * MaxPointsPerPage controls "TeeChart AutoPaging".
     * Setting it to a number greater than zero makes TeeChart internally
     * divide Series points in Pages. You can then navigate across Chart pages
     * by using Chart.Page and Chart.NumPages.
     * For each Page, TeeChart will automatically calculate and display the
     * corresponding Series points. The last page can have fewer points than
     * other pages. You can use the Chart.ScaleLastPage to control if last
     * page will be "stretched" or not.<br>
     * Default value: 0
     *
     * <p>Example:
     * <pre><font face="Courier" size="4">
     * myChart.getPage().setMaxPointsPerPage(6);
     * </font></pre></p>
     *
     * @see Page#getMaxPointsPerPage
     * @param value int
     */
    public function setMaxPointsPerPage($value) {
        $this->maxPoints = $this->setIntegerProperty($this->maxPoints, $value);
    }

    /**
     * Determines how the last Chart page will be displayed.<br>
     * It only has effect when TChart.MaxPointsPerPage is greater than zero.
     * When true, the last Chart page will have the same horizontal scaling as
     * the other pages. When false, the last Chart page scaling will be
     * adjusted based on the number of visible points on that last page.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getScaleLastPage() {
        return $this->scaleLast;
    }

    /**
     * Determines how the last Chart page will be displayed.<br>
     * Default value: true
     *
     * @see Page#getScaleLastPage
     * @param value boolean
     */
    public function setScaleLastPage($value) {
        $this->scaleLast = $this->setBooleanProperty($this->scaleLast, $value);
    }

    /**
     * Moves to next page ( Current + 1 )<br>
     * When MaxPointsPerPage is greater than Zero, TeeChart automatically
     * divides point values in Pages. Calling Next is the same as
     * Page = Page + 1. The NumPages chart property returns the total number of
     * pages.
     *
     */
    public function next() {
        if (($this->maxPoints > 0) && ($this->current < $this->getCount())) {
            $this->setCurrent($this->current + 1);
        }
    }

    /**
     * Moves to previous page ( Current - 1 )<br>
     * When MaxPointsPerPage is greater than Zero, TeeChart automatically
     * divides point values in Pages. Calling Previous is the same as
     * Page = Page - 1 (Go back a page). The Count property returns the total
     * number of pages.
     *
     */
    public function previous() {
        if (($this->maxPoints > 0) && ($this->current > 1)) {
            $this->setCurrent($this->current - 1);
        }
    }
}
?>