<?php
  /**
 * Description:  This file contains the following class:<br>
 * Spline class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: Spline class</p>
 *
 * <p>Description: Spline smoothing.</p>
 *
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class Spline {

    private $build;
    private $capacity;
    private $interpolate;
    private $pointList=Array();
    private $knuckleList=Array();
    private $vertexList=Array();
    private $matrix=Array();
    private $fragments=100;
    private $noPoints=0;
    private $noVertices;

    /**
     * Spline smoothing.
     */
    public function __construct() {}

    /**
     * Indicates the spline has already calculated smooth points. <br>
     * Set to false to force the spline to rebuild smooth points.<br>
     *
     * @return boolean
     */
    public function getBuild() {
        return $this->build;
    }

    /**
     * Indicates the spline has already calculated smooth points. <br>
     * Set to false to force the spline to rebuild smooth points.<br>
     *
     * @param value boolean
     */
    public function setBuild($value) {
        if (!$value) {
            // Release allocated memory for vertices
            if ($this->build) {
                $this->clearVertexList();
            }
            $this->noVertices = 0;
        }
        $this->build = $value;
    }

    private function setCapacity($value) {

        if ($value != $this->capacity) {
            $currentSize = $this->capacity;
            $oldPoints[] = $this->pointList;
            $oldKnuckle[] = $this->knuckleList;
            $this->pointList = null;
            $this->knuckleList = null;

            if ($value > 0) {
                $this->pointList[] = $value;
                $this->knuckleList[] = $value;

                if ($this->capacity != 0) {
                    $this->pointList=Utils::array_copy($oldPoints);
                    $this->knuckleList=Utils::array_copy($oldKnuckle);                    
                }
            }

            if ($currentSize != 0) {
                $oldPoints = null;
                $oldKnuckle = null;
            }

            $this->capacity = $value;
        }
    }

    /**
     * The number of resulting smooth points.<br>
     * Must be a multiple of source points.
     *
     * @return int
     */
    public function getFragments() {
        return $this->fragments;
    }

    /**
     * Sets the number of resulting smooth points.<br>
     * Must be a multiple of source points.
     *
     * @param value int
     */
    public function setFragments($value) {
        if ($this->fragments != $value) {
            $this->fragments = min($value, 600);
        }
    }

    /**
     * When true, the spline calculates interpolated points that will pass
     * exactly over source points.<br>
     * When false, the spline resulting points do not necessarily pass over
     * source points. <br>
     * Default value: false
     *
     * @return boolean
     */
    public function getInterpolated() {
        return $this->interpolate;
    }

    /**
     * When true, the spline calculates interpolated points that will pass
     * exactly over source points.<br>
     * When false, the spline resulting points do not necessarily pass over
     * source points. <br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setInterpolated($value) {
        if ($value != $this->interpolate) {
            $this->interpolate = $value;
            $this->setBuild(false);
        }
    }

    public function getPoint($index) {
        return $this->pointList[$index];
    }
    /**
     * Use to set the source point for the Knuckle <br><br>
     *
     * @param index int
     * @param value Double
     */
    public function setPoint($index, $value) {
        $this->pointList[$index] = $value;
        $this->setBuild(false);
    }
    /**
     * Makes the Index source point a control point. <br><br>
     * By default, TSmoothingFunction does not set any source point <br>
     * as a control point.
     *
     * @param index int
     * @return Double
     */
    private function getKnuckle($index) {
        if (($index == 0) || ($index == $this->noPoints - 1)) {
            return false;
        } else {
            return $this->knuckleList[$index];
        }
    }
    /**
     * Makes the Index source point a control point. <br><br>
     * By default, TSmoothingFunction does not set any source point <br>
     * as a control point.
     *
     * @param index int
     * @param value boolean
     */
    public function setKnuckle($index, $value) {
        $this->knuckleList[$index] = $value;
        $this->setBuild(false);
    }

    /**
     * Returns the number of total source points. <br>
     * For each point that is a control point ( Knuckle[ Index ] is true ),
     * the number of vertices is incremented by 2. <br>
     *
     * @return int
     */
    public function numberOfVertices() {
        if (!$this->build) {
            $this->rebuild();
        }
        return $this->noVertices;
    }

    static $MINLIMIT = 1e-5;

    private function fillMatrix() {
        if (($this->noVertices > 2) && ($this->noVertices <= 250)) {

            for ($i = 2; $i < $this->noVertices; $i++) {
                $this->matrix[$i][$i - 1] = 1 / 6;
                $this->matrix[$i][$i] = 2 / 3;
                $this->matrix[$i][$i + 1] = 1 / 6;
            }

            $this->matrix[1][1] = 1;
            $this->matrix[$this->noVertices][$this->noVertices] = 1;

            $i = 3;
            while ($i < $this->noVertices - 1) {
                if ((abs($this->vertexList[$i]->x -
                    $this->vertexList[$i - 1]->x) < self::$MINLIMIT) &&
                    (abs($this->vertexList[$i + 1]->x - $this->vertexList[$i]->x) <
                     self::$MINLIMIT) &&
                    (abs($this->vertexList[$i]->y - $this->vertexList[$i - 1]->y) <
                     self::$MINLIMIT) &&
                    (abs($this->vertexList[$i + 1]->y - $this->vertexList[$i]->y) <
                     self::$MINLIMIT)) {
                    for ($j = $i - 1; $j <= $i + 1; $j++) {
                        $this->matrix[$j][$j - 1] = 0;
                        $this->matrix[$j][$j] = 1;
                        $this->matrix[$j][$j + 1] = 0;
                    }

                    $i += 2;
                } else {
                    $i++;
                }
            }
        }
    }

    /**
     * Calculates new smoothed points from list of points.
     */
    public function rebuild() {

        if ($this->noPoints > 1) {
            $this->clearVertexList();
            $this->noVertices = 0;

            for ($i = 0; $i < $this->noPoints; $i++) {
                if ($this->getKnuckle($i)) {
                    $this->noVertices += 3;
                } else {
                    $this->noVertices++;
                }
            }                           
            $this->vertexList=Array();
            //$this->vertexList[] = new TeePoint();
//            $this->vertexList = new TeePoint[$this->noVertices + 2];

            $j = 0;
            for ($i = 0; $i < $this->noPoints; $i++) {
                $vertex2D = $this->getPoint($i);
                if ($this->getKnuckle($i)) {
                    $this->vertexList[$j + 1] = $vertex2D;
                    $this->vertexList[$j + 2] = $vertex2D;
                    $j += 2;
                }
                $this->vertexList[$j + 1] = $this->pointList[$i];
                $j++;
            }

            if ($this->interpolate) {
//                $matrix = new double[noVertices + 1][];
                $this->matrix = Array();
                for ($i = 1; $i <= $this->noVertices; $i++) {
                    $this->matrix[$i] = Array();
                    for ($tt=0;$tt<$this->noVertices+1;$tt++)
                       $this->matrix[$i][$tt]=0.0;
//                    $this->matrix[$i] = new double[noVertices + 1];
                }

                $this->fillMatrix();
                $this->doInterpolate();
                $this->matrix = null;
            }      
        }
        $this->build = true;
        $this->phantomPoints();
    }

    private function doInterpolate() {
        if (($this->noVertices < 250) && ($this->noVertices > 2)) {
            $tmp = Array();
            for ($tt=0;$tt<$this->noVertices+2;$tt++)
                 $tmp[$tt]=new TeePoint(0,0);
//            Point.Double[] tmp = new Point.Double[noVertices + 2];

            for ($i = 1; $i <= $this->noVertices; $i++) {
                for ($j = $i + 1; $j <= $this->noVertices; $j++) {
                    $factor = $this->matrix[$j][$i] / $this->matrix[$i][$i];
                    for ($k = 1; $k <= $this->noVertices; $k++) {
                        $this->matrix[$j][$k] = $this->matrix[$j][$k] - $factor * $this->matrix[$i][$k];
                    }

                    $this->vertexList[$j]->x = (float) ($this->vertexList[$j]->x -
                                               $factor * $this->vertexList[$j - 1]->x);
                    $this->vertexList[$j]->y = (float) ($this->vertexList[$j]->y -
                                               $factor * $this->vertexList[$j - 1]->y);
                }
            }

            $tmp[$this->noVertices] = new TeePoint(
                    (float) ($this->vertexList[$this->noVertices]->x /
                             $this->matrix[$this->noVertices][$this->noVertices]),
                    (float) ($this->vertexList[$this->noVertices]->y /
                             $this->matrix[$this->noVertices][$this->noVertices]));

            for ($i = $this->noVertices - 1; $i >= 1; $i--) {
                $tmp[$i] = new TeePoint(
                        (float) ((1 / $this->matrix[$i][$i]) *
                                 ($this->vertexList[$i]->x - $this->matrix[$i][$i +
                                  1] * $tmp[$i + 1]->x)),
                        (float) ((1 / $this->matrix[$i][$i]) *
                                 ($this->vertexList[$i]->y - $this->matrix[$i][$i +
                                  1] * $tmp[$i + 1]->y)));
            }

            $this->clearVertexList();
            $this->vertexList = $tmp;
        }
    }

    /**
     * Adds a new source point with specified X and Y values.
     *
     * @param x double
     * @param y double
     */
    public function addPoint($x, $y) {
        if ($this->noPoints == $this->capacity) {
            $this->setCapacity($this->capacity + 25);
        }
        $this->setPoint($this->noPoints, new TeePoint($x, $y));
        $this->noPoints++;
        $this->setBuild(false);
    }

    private function clearVertexList() {
        $this->vertexList = null;
    }

    /**
     * Removes all source points.
     */
    public function clear() {
        if ($this->numberOfVertices() > 0) {
            $this->clearVertexList();
        }
        $this->noPoints = 0;
        $this->noVertices = 0;
        $this->setBuild(false);
        $this->setCapacity(0);
        $this->interpolate = false;
        $this->fragments = 100;
    }

    private function phantomPoints() {
        if ($this->numberOfVertices() > 1) {
            $i = 0;

            $this->vertexList[$i] = new TeePoint(
                    2 * $this->vertexList[$i + 1]->x - $this->vertexList[$i + 2]->x,
                    2 * $this->vertexList[$i + 1]->y - $this->vertexList[$i + 2]->y);

            $this->vertexList[$this->numberOfVertices() + 1] = new TeePoint(
                    2 * $this->vertexList[$this->numberOfVertices()]->x -
                    $this->vertexList[$this->numberOfVertices() - 1]->x,
                    2 * $this->vertexList[$this->numberOfVertices()]->y -
                    $this->vertexList[$this->numberOfVertices() - 1]->y);
        }
    }

    /**
     * Returns an interpolated point.
     *
     * @param parameter double
     * @return Double
     */
    public function value($parameter) {
        $result = new TeePoint(0, 0);

        if ($this->noPoints < 2) {
            return $result;
        }

        if (!$this->build) {
            $this->rebuild();
        }

        (double) $mid = ($this->numberOfVertices() - 1) * (float)$parameter + 1;
        $s = max(0, (int) $mid - 1);
        $e = $s + 3;
        if ($s > $this->noVertices + 1) {
            $s = $this->noVertices + 1;
        }

        for ($c = $s; $c <= $e; $c++) {
            (double) $dist = abs($c - $mid);
            if ($dist < 2) {
                (double) $mix = ($dist < 1) ?
                             (4.0 / 6.0) - ($dist * $dist) +
                             (0.5 * $dist * $dist * $dist) :
                             (2 - $dist) * (2 - $dist) * (2 - $dist) / 6;
                $result->x += (float) ($this->vertexList[$c]->x * $mix);
                $result->y += (float) ($this->vertexList[$c]->y * $mix);
            }
        }
        return $result;
    }
}

?>