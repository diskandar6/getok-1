<?php
 /**
 * Description:  This file contains the following class:<br>
 * HatchStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * HatchStyle class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

 class HatchStyle {

    public static $HORIZONTAL = 0;
    public static $VERTICAL = 1;
    public static $FORWARDDIAGONAL = 2;
    public static $BACKWARDDIAGONAL = 3;
    public static $CROSS = 4;
    public static $DIAGONALCROSS = 5;
    public static $PERCENT05 = 6;
    public static $PERCENT10 = 7;
    public static $PERCENT20 = 8;
    public static $PERCENT25 = 9;
    public static $PERCENT30 = 10;
    public static $PERCENT40 = 11;
    public static $PERCENT50 = 12;
    public static $PERCENT60 = 13;
    public static $PERCENT70 = 14;
    public static $PERCENT75 = 15;
    public static $PERCENT80 = 16;
    public static $PERCENT90 = 17;
    public static $LIGHTDOWNWARDDIAGONAL = 18;
    public static $LIGHTUPWARDDIAGONAL = 19;
    public static $DARKDOWNWARDDIAGONAL = 20;
    public static $DARKUPWARDDIAGONAL = 21;
    public static $WIDEDOWNWARDDIAGONAL = 22;
    public static $WIDEUPWARDDIAGONAL = 23;
    public static $LIGHTVERTICAL = 24;
    public static $LIGHTHORIZONTAL = 25;
    public static $NARROWVERTICAL = 26;
    public static $NARROWHORIZONTAL = 27;
    public static $DARKVERTICAL = 28;
    public static $DARKHORIZONTAL = 29;
    public static $DASHEDDOWNWARDDIAGONAL = 30;
    public static $DASHEDUPWARDDIAGONAL = 31;
    public static $DASHEDHORIZONTAL = 32;
    public static $DASHEDVERTICAL = 33;
    public static $SMALLCONFETTI = 34;
    public static $LARGECONFETTI = 35;
    public static $ZIGZAG = 36;
    public static $WAVE = 37;
    public static $DIAGONALBRICK = 38;
    public static $HORIZONTALBRICK = 39;
    public static $WEAVE = 40;
    public static $PLAID = 41;
    public static $DIVOT = 42;
    public static $DOTTEDGRID = 43;
    public static $DOTTEDDIAMOND = 44;
    public static $SHINGLE = 45;
    public static $TRELLIS = 46;
    public static $SPHERE = 47;
    public static $SMALLGRID = 48;
    public static $SMALLCHECKERBOARD = 49;
    public static $LARGECHECKERBOARD = 50;
    public static $OUTLINEDDIAMOND = 51;
    public static $SOLIDDIAMOND = 52;
    public static $SOLID = 53;
    public static $CLEAR = 54;

    public function __construct() {
    }

    public function fromInt($value) {
        switch ($value) {

        case 0:
            return self::$HORIZONTAL;
        case 1:
            return self::$VERTICAL;
        case 2:
            return self::$FORWARDDIAGONAL;
        case 3:
            return self::$BACKWARDDIAGONAL;
        case 4:
            return self::$CROSS;
        case 5:
            return self::$DIAGONALCROSS;
        case 6:
            return self::$PERCENT05;
        case 7:
            return self::$PERCENT10;
        case 8:
            return self::$PERCENT20;
        case 9:
            return self::$PERCENT25;
        case 10:
            return self::$PERCENT30;
        case 11:
            return self::$PERCENT40;
        case 12:
            return self::$PERCENT50;
        case 13:
            return self::$PERCENT60;
        case 14:
            return self::$PERCENT70;
        case 15:
            return self::$PERCENT75;
        case 16:
            return self::$PERCENT80;
        case 17:
            return self::$PERCENT90;
        case 18:
            return self::$LIGHTDOWNWARDDIAGONAL;
        case 19:
            return self::$LIGHTUPWARDDIAGONAL;
        case 20:
            return self::$DARKDOWNWARDDIAGONAL;
        case 21:
            return self::$DARKUPWARDDIAGONAL;
        case 22:
            return self::$WIDEDOWNWARDDIAGONAL;
        case 23:
            return self::$WIDEUPWARDDIAGONAL;
        case 24:
            return self::$LIGHTVERTICAL;
        case 25:
            return self::$LIGHTHORIZONTAL;
        case 26:
            return self::$NARROWVERTICAL;
        case 27:
            return self::$NARROWHORIZONTAL;
        case 28:
            return self::$DARKVERTICAL;
        case 29:
            return self::$DARKHORIZONTAL;
        case 30:
            return self::$DASHEDDOWNWARDDIAGONAL;
        case 31:
            return self::$DASHEDUPWARDDIAGONAL;
        case 32:
            return self::$DASHEDHORIZONTAL;
        case 33:
            return self::$DASHEDVERTICAL;
        case 34:
            return self::$SMALLCONFETTI;
        case 35:
            return self::$LARGECONFETTI;
        case 36:
            return self::$ZIGZAG;
        case 37:
            return self::$WAVE;
        case 38:
            return self::$DIAGONALBRICK;
        case 39:
            return self::$HORIZONTALBRICK;
        case 40:
            return self::$WEAVE;
        case 41:
            return self::$PLAID;
        case 42:
            return self::$DIVOT;
        case 43:
            return self::$DOTTEDGRID;
        case 44:
            return self::$DOTTEDDIAMOND;
        case 45:
            return self::$SHINGLE;
        case 46:
            return self::$TRELLIS;
        case 47:
            return self::$SPHERE;
        case 48:
            return self::$SMALLGRID;
        case 49:
            return self::$SMALLCHECKERBOARD;
        case 50:
            return self::$LARGECHECKERBOARD;
        case 51:
            return self::$OUTLINEDDIAMOND;
        case 52:
            return self::$SOLIDDIAMOND;
        case 53:
            return self::$SOLID;
        case 54:
            return self::$CLEAR;
        default:
            return self::$SOLID;
        }
    }

    public function getImage($c) {
        return ImageUtils::getImage($this->getClass()->getResource(
                    "hatches/"
                    . self::$DESCRIPTIONS[$this->getValue()]
                    . ".$this->gif"), $c);
        /*
        return Toolkit.getDefaultToolkit().createImage(getClass().getResource(
                "hatches/" + DESCRIPTIONS[getValue()] + ".gif"));
         */
    }

    public static $DESCRIPTIONS = Array(
      "Horizontal",
      "Vertical",
      "ForwardDiagonal",
      "BackwardDiagonal",
      "Cross",
      "DiagonalCross",
      "Percent05",
      "Percent10",
      "Percent20",
      "Percent25",
      "Percent30",
      "Percent40",
      "Percent50",
      "Percent60",
      "Percent70",
      "Percent75",
      "Percent80",
      "Percent90",
      "LightDownwardDiagonal",
      "LightUpwardDiagonal",
      "DarkDownwardDiagonal",
      "DarkUpwardDiagonal",
      "WideDownwardDiagonal",
      "WideUpwardDiagonal",
      "LightVertical",
      "LightHorizontal",
      "NarrowVertical",
      "NarrowHorizontal",
      "DarkVertical",
      "DarkHorizontal",
      "DashedDownwardDiagonal",
      "DashedUpwardDiagonal",
      "DashedHorizontal",
      "DashedVertical",
      "SmallConfetti",
      "LargeConfetti",
      "ZigZag",
      "Wave",
      "DiagonalBrick",
      "HorizontalBrick",
      "Weave",
      "Plaid",
      "Divot",
      "DottedGrid",
      "DottedDiamond",
      "Shingle",
      "Trellis",
      "Sphere",
      "SmallGrid",
      "SmallCheckerBoard",
      "LargeCheckerBoard",
      "OutlinedDiamond",
      "SolidDiamond",
      "Solid",
      "Clear"
      );
}

?>