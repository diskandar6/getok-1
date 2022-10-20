<?php
/**
 * Description:  This file contains the following class:<br>
 * ChartFont class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * ChartFont class
 *
 * Description: Common Chart Font. Font methods used at several objects
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class ChartFont extends TeeBase
{

   private $fontSize = 8;
   private $bold = false;
   private $bBrush;
   private $font;// = new Font(DEFAULTFAMILY, Font.PLAIN, DEFAULTSIZE);
   private $italic = false;
   private $name = "";
   private $shadow = null;
   private $size=8;
   private $strikeout = false;
   private $underline = false;
   private $outline = null;

   public static $DEFAULTSIZE = 8;
   public static $DEFAULTFAMILY = "fonts/verdana.ttf";
//   public static $DEFAULTFAMILY = "fonts/DejaVuSansCondensed.ttf";
   public $fontCondensed;
   public $fontCondensedBold;
   public $Style="";



   public function __construct($c = null)
   {
      parent::__construct($c);
     
      $baseDir = dirname(__FILE__) . "/../";

      // Free low-res fonts based on Bitstream Vera <http://dejavu.sourceforge.net/wiki/>
//      $this->fontCondensed = $baseDir . "fonts/DejaVuSansCondensed.ttf";
      $this->fontCondensed = $baseDir . "fonts/verdanadensed.ttf";
      $this->fontCondensedBold = $baseDir . "fonts/DejaVuSansCondensed-Bold.ttf";

      self::$DEFAULTFAMILY = $baseDir . "fonts/verdana.ttf";
//      self::$DEFAULTFAMILY = $baseDir . "fonts/DejaVuSansCondensed.ttf";// Arial;
      $this->name = self::$DEFAULTFAMILY;
      $this->size = self::$DEFAULTSIZE;
   }
   
    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->fontSize);
        unset($this->bold);
        unset($this->bBrush);
        unset($this->font);
        unset($this->italic);
        unset($this->name);
        unset($this->shadow);
        unset($this->size);
        unset($this->strikeout);
        unset($this->underline);
        unset($this->outline);
        unset($this->fontCondensed);
        unset($this->fontCondensedBold);
        unset($this->Style);
    }   

   /**
   * Gets a Font type for text.<br>
   * Default value: Arial
   *
   * @return String
   */
   public function getName()
   {
      return $this->name;
   }

   /**
   * Gets the Font name as text without the path.<br>
   *
   * @return String
   */
   public function getFontName()
   {
       // Extract the font name from the entire path
       // TODO pep
      return $this->name;
   }
   
   /**
   * Specifies a Font type for text.<br>
   * Default value: Arial
   *
   * @param value String
   */
   public function setName($value)
   {
      $this->name = $this->setStringProperty($this->name, $value);
   }

   private function changed()
   {
      if($this->chart != null)
      {
         $this->chart->doChangedFont($this);
      }
   }

   /**
   * Use Invalidate when the entire canvas needs to be repainted.<br>
   * When more than one region within the canvas needs repainting, Invalidate
   * will cause the entire window to be repainted in a single pass, avoiding
   * flicker caused by redundant repaints.<br>
   * There is no performance penalty for calling Invalidate multiple times
   * before the control is actually repainted.
   */
   public function invalidate()
   {
      parent::invalidate();

      if($this->font != null)
      {
         $this->font = null;
      }

      $this->changed();
   }

   function hasOutline()
   {
      return($this->outline != null) && $this->outline->visible;
   }

   /**
   * The Font size (in points) for text.<br>
   * When managing Font sizes of Drawing Canvas custom outputted text
   * relative to Chart text (titles, labels, etc.), use Font.Height to size
   * the Canvas text. <br>
   * Default value: 8
   *
   * @return int
   */
   public function getSize()
   {
      return $this->size;
   }

   /**
   * Sets Font sizing (in points) for text.<br>
   * Default value: 8
   *

   * @param value int
   */
   public function setSize($value)
   {
      $this->size = $this->setIntegerProperty($this->size, $value);
   }

   /**
   * Bold Font for text.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getBold()
   {
      return $this->bold;
   }

   /**
   * Sets Font bold for text.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setBold($value)
   {
      $this->bold = $this->setBooleanProperty($this->bold, $value);
      // if True default bold font is used. If set to false default not bold
      // font is used.
      if ($value==true)
        $this->name = $this->fontCondensedBold;
      else
        $this->name = $this->fontCondensed;
   }

   public function reset()
   {
      $this->setColor(new Color(0, 0, 0));
      $this->setBold(false);
      $this->setItalic(false);
      $this->setUnderline(false);
      $this->setName(self::$DEFAULTFAMILY);
      $this->setSize(self::$DEFAULTSIZE);
   }

   /**
   * Italic Font (true or false) for text.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getItalic()
   {
      return $this->italic;
   }

   /**
   * Sets Font italic (true or false) for text.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setItalic($value)
   {
      $this->italic = $this->setBooleanProperty($this->italic, $value);
   }

   /**
   * Underline Font for text.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getUnderline()
   {
      return $this->underline;
   }

   /**
   * Sets Font underline on/off.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setUnderline($value)
   {
      $this->underline = $this->setBooleanProperty($this->underline, $value);
   }

   /**
   * Font Strikeout on/off.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getStrikeout()
   {
      return $this->strikeout;
   }

   /**
   * Sets Font Strikeout on/off.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setStrikeout($value)
   {
      $this->strikeout = $this->setBooleanProperty($this->strikeout, $value);
   }

   /**
   * Defines a Font colour for text.
   *
   * @return Color
   */
   public function getColor()
   {
      return $this->getBrush()->getColor();
   }

   /**
   * Defines a Font colour for text.
   *
   * @param value Color
   */
   public function setColor($value)
   {
      $this->getBrush()->setColor($value);
   }

   /**
   * Applies a gradient fill to the font.<br>
   *
   * @return Gradient
   */
   public function getGradient()
   {
      return $this->getBrush()->getGradient();
   }

   /**
   * Accesses the shadow properties of the font.
   *
   * @return Shadow
   */
   public function getShadow()
   {
      if($this->shadow == null)
      {
         $this->shadow = new Shadow($this->chart, 1);
      }
      return $this->shadow;
   }

   public function shouldDrawShadow()
   {
      return(($this->shadow != null) && $this->shadow->getVisible() &&
      (($this->shadow->getWidth() != 0) || ($this->shadow->getHeight() != 0)));
   }

   public function assign($f)
   {
      if ($f->bBrush == null) {
        $this->bBrush = null;
      } else {
        $this->getBrush()->assign($f->bBrush);
      }

      if ($f->shadow == null) {
        $this->shadow = null;
      } else {
        $this->getShadow()->assign($f->shadow);
      }

      if ($f->outline == null) {
        $this->outline = null;
      } else {
        $this->getOutline()->assign($f->outline);
      }

      $this->bold = $f->bold;
      $this->strikeout = $f->strikeout;
      $this->underline = $f->underline;
      $this->italic = $f->italic;

      $this->name = $f->getName();
      $this->size = $f->size;
      $this->font = null;
      $this->changed();
   }

   /* todo    public function getDrawingFont() {
   if ($this->font == null) {
   $style=$this->Font.PLAIN;

   if (bold) {
   style = Font.BOLD;
   } else {
   style = Font.PLAIN;
   }

   if (italic) {
   style |= Font.ITALIC;
   }

   /** todo UNDERLINE AND STRIKEOUT DO NOT EXIST IN JAVA FONT */
   //            if (underline) {
   //                style |= Font.UNDERLINE;
   //            }
   //            if (strikeout) {
   //                style |= Font.Strikeout;
   //            }

   /** @todo CREATE FONT USING MAP OBJECT WITH TEXTATTRIBUTE (Strike, Underline, etc) */
   /** @todo INSTEAD OF CREATING IT HERE WITH A SIMPLE "style" value */
   //MM change .. create with null to create default and accept all unicode types
   //            font = new Font(null, style, size);
   //        }
   //        return font;
   //    }

   public function setChart($c)
   {
      parent::setChart($c);
      if($this->shadow != null)
      {
         $this->shadow->setChart($this->chart);
      }
      if($this->bBrush != null)
      {
         $this->bBrush->setChart($this->chart);
      }
      if($this->outline != null)
      {
         $this->outline->setChart($this->chart);
      }
   }

   /**
   * Sets the Brush characteristics of the font.
   *
   * @return ChartBrush
   */
   public function getBrush()
   {
      if($this->bBrush == null)
      {
         $this->bBrush = new ChartBrush($this->chart, new Color(0, 0, 0));
      }
      return $this->bBrush;
   }

   public function getOutline()
   {
      if($this->outline == null)
      {
         $this->outline = new ChartPen($this->chart, null, false);
      }
      return $this->outline;
   }

   public function getFontSize()
   {
      return $this->size;
   }
}
?>