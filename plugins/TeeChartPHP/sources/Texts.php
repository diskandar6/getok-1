<?php
 /**
 * Description:  This file contains the following class:<br>
 * Texts class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * Texts class
 *
 * Description: Text message and dialogue static finalants
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Texts {

    public function __construct() {} // Prevent instantiation

    static public function translate($value) {}

    static public $translator;

    public static $TeeChart = "TeeChart";
    public static $Copyright = " 1995-2018 by Steema Software";
    public static $VersionMode = "EVALUATION VERSION";
    public static $BuildNumber = "2018.03.07.000";

    public static $POLAR_DEGREE_SYMBOL =  "º"; //"&deg;";

    // char static finals
    public static $FieldsSeparator = "\t";
    // MM change \n public static char LineSeparator   ; /* unicode "\\u000"
    // To separate lines of text
    public static $LineSeparator = "\n";
    public static $CarriageReturnChar = "\r"; //Carriage return
    public static $ColumnSeparator = " aaa"; // To separate columns in Legend

    // $static finalants
    public static $CharForHeight = "W"; // <-- this is used to calculate Text Height
    public static $DefPercentFormat = "##0.## %";
    public static $DefValueFormat = "#,##0.###";
    public static $DefLogValueFormat = "#.0 \"x10\" E+0";
    public static $ValuesX = "X";
    public static $ValuesY = "Y";
    public static $ValuesZ = "Z";

    // Tool descriptions
    public static $ChartImageDesc = "Displays a picture using the specified Series axes as boundaries. When the axis are zoomed or scrolled, the picture will follow the new boundaries.";
    public static $CursorToolDesc =
            "Displays draggable Cursor lines on top of Series.";
    public static $DragMarksDesc =
            "Moves Series marks when dragging them with mouse.";
    public static $DragPointDesc =
            "Moves a Series point when dragging it with mouse.";
    public static $DrawLineDesc =
            "Allows drawing custom lines by dragging the mouse.";
    public static $ExtraLegendDesc =
            "Displays a custom legend at any location inside Chart.";
    public static $GanttToolDesc =
            "Allows dragging and resizing Gantt bars.";
    public static $MarksTipDesc = "Displays \"tips\" or \"hints\" when the end-user moves or clicks the mouse over a series point.";
    public static $NearestPointDesc =
            "Displays a graphical signal when the mouse is moving near a series point.";
    public static $PieToolDesc =
            "Outlines or expands Pie slices when moving or clicking with mouse.";
    public static $SeriesAnimationDesc =
            "Performs growing animation of Series points.";
    public static $AxisArrowDesc =
            "Displays clickable arrows at axis start and ending points, to scroll axis.";
    public static $ColorBandDesc =
            "Displays a coloured rectangle (band) at the specified axis and position.";
    public static $ColorLineDesc =
            "Displays a draggable line across axes.";
    public static $GridBandDesc = "Grid Band tool, use it to display a coloured rectangles (bands) at the grid lines of the specified axis and position.";
    public static $GridTransposeDesc =
            "Exchanges X and Z coordinates to rotate Series 90 degree.";
    public static $AnnotationDesc =
            "Displays custom text at any location inside Chart.";
    public static $RotateDesc =
            "Allows rotating Chart dragging with mouse button.";

    public static $crlf="\r\n";

    // Translation
    public static $languageCode;
    public static $LegendFirstValue;
    public static $LegendColorWidth;
    public static $SeriesSetDataSource;
    public static $SeriesInvDataSource;
    public static $FillSample;
    public static $AxisLogDateTime;
    public static $AxisLogNotPositive;
    public static $AxisLabelSep;
    public static $AxisIncrementNeg;
    public static $AxisMinMax;
    public static $AxisMaxMin;
    public static $AxisLogBase;
    public static $MaxPointsPerPage;
    public static $Percent3D;
    public static $CircularSeries;
    public static $WarningHIColor;
    public static $DefaultPercentOf;
    public static $DefaultPercentOf2;
    public static $AxisTitle;
    public static $AxisLabels;
    public static $RefreshInterval;
    public static $SeriesParentNoSelf;
    public static $GalleryLine;
    public static $GalleryPoint;
    public static $GalleryArea;
    public static $GalleryBar;
    public static $GalleryBar3D;
    public static $GalleryHorizBar;
    public static $Stack;
    public static $GalleryPie;
    public static $GalleryCandle;
    public static $GalleryCircled;
    public static $GalleryFastLine;
    public static $GalleryHorizLine;

    public static $PieSample1;
    public static $PieSample2;
    public static $PieSample3;
    public static $PieSample4;
    public static $PieSample5;
    public static $PieSample6;
    public static $PieSample7;
    public static $PieSample8;

    public static $GalleryLogoFont;
    public static $Editing;

    public static $GalleryStandard;
    public static $GalleryExtended;
    public static $GalleryFunctions;

    public static $EditChart;
    public static $Options;
    public static $OnlineSupport;
    public static $PrintPreview;
    public static $ExportChart;
    public static $ImportChart;
    public static $CustomAxes;

    public static $InvalidEditorClass;
    public static $MissingEditorClass;

    public static $GalleryArrow;

    public static $ExpFinish;
    public static $ExpNext;

    public static $GalleryGantt;

    public static $GanttSample1;
    public static $GanttSample2;
    public static $GanttSample3;
    public static $GanttSample4;
    public static $GanttSample5;
    public static $GanttSample6;
    public static $GanttSample7;
    public static $GanttSample8;
    public static $GanttSample9;
    public static $GanttSample10;

    public static $ChangeSeriesTitle;
    public static $NewSeriesTitle;
    public static $DateTime;
    public static $TopAxis;
    public static $BottomAxis;
    public static $LeftAxis;
    public static $RightAxis;

    public static $SureToDelete;
    public static $DateTimeFormat;
    public static $Default;
    public static $ValuesFormat;
    public static $Maximum;
    public static $Minimum;
    public static $DesiredIncrement;

    public static $IncorrectMaxMinValue;
    public static $EnterDateTime;

    public static $SureToApply;
    public static $SelectedSeries;
    public static $RefreshData;

    public static $DefaultFontSize = "8";
    public static $DefaultEditorSize = "414";
    public static $DefaultEditorHeight = "347";

    public static $FunctionAdd;
    public static $FunctionSubtract;
    public static $FunctionMultiply;
    public static $FunctionDivide;
    public static $FunctionHigh;
    public static $FunctionLow;
    public static $FunctionAverage;

    public static $GalleryShape;
    public static $GalleryBubble;
    public static $GalleryBarJoin;
    public static $GalleryDonut;
    public static $GalleryPolar;
    public static $GalleryRadar;
    public static $GalleryVolume;
    public static $GalleryPoint3D;
    public static $GalleryPyramid;
    public static $GalleryWindRose;
    public static $GalleryClock;
    public static $GalleryLinePoint;
    public static $GallerySurface;
    public static $GalleryColorGrid;

    public static $FunctionNone;
    public static $AxisDlgValue;

    public static $None;

    public static $DefaultFontName;

    public static $CheckPointerSize;
    public static $About;

    public static $DataSet;
    public static $AskDataSet;

    public static $SingleRecord;
    public static $AskDataSource;

    public static $Summary;

    public static $FunctionPeriod;

    public static $WizardTab;
    public static $ChartWizard;

    public static $ClearImage;
    public static $BrowseImage;

    public static $WizardSureToClose;
    public static $FieldNotFound;

    public static $DepthAxis;
    public static $PieOther;
    public static $ShapeGallery1;
    public static $ShapeGallery2;

    public static $ValuesPie = "Pie";
    public static $ValuesBar = "Bar";
    public static $ValuesAngle = "Angle";
    public static $ValuesGanttStart = "Start";
    public static $ValuesGanttEnd = "End";
    public static $ValuesGanttNextTask = "NextTask";
    public static $ValuesBubbleRadius = "Radius";
    public static $ValuesArrowEndX = "EndX";
    public static $ValuesArrowEndY = "EndY";

    public static $Legend;
    public static $Title;
    public static $Foot;
    public static $Period;
    public static $PeriodRange;
    public static $CalcPeriod;
    public static $SmallDotsPen;

    public static $InvalidTeeFile;
    public static $WrongTeeFileFormat;
    public static $EmptyTeeFile;

    public static $CustomAxesEditor;
    public static $Series;
    public static $SeriesList;

    public static $PageOfPages;
    public static $FileSize;

    public static $First;
    public static $Prior;
    public static $Next;
    public static $Last;
    public static $Insert;
    public static $Delete;
    public static $Post;
    public static $Cancel;

    public static $All;
    public static $Index;
    public static $Text;

    public static $AsBMP;
    public static $BMPFilter;
    public static $AsEMF;
    public static $EMFFilter;
    public static $WMFFilter;
    public static $ExportPanelNotSet;

    public static $TextFilter;
    public static $XMLFilter;
    public static $ExcelFilter;
    public static $HTMLFilter;
    public static $SVGFilter;

    public static $Normal;
    public static $NoBorder;
    public static $Dotted;
    public static $Colors;
    public static $Filled;
    public static $Marks;
    public static $Stairs;
    public static $Points;
    public static $Height;
    public static $Hollow;
    public static $Point2D;
    public static $Triangle;
    public static $Star;
    public static $Circle;
    public static $DownTri;
    public static $Cross;
    public static $Diamond;
    public static $NoLines;
    public static $Stack100;
    public static $Pyramid;
    public static $Ellipse;
    public static $InvPyramid;
    public static $Sides;
    public static $SideAll;
    public static $Patterns;
    public static $Exploded;
    public static $Shadow;
    public static $SemiPie;
    public static $Rectangle;
    public static $VertLine;
    public static $HorizLine;
    public static $Line;
    public static $Cube;
    public static $DiagCross;

    public static $CanNotFindTempPath;
    public static $CanNotCreateTempChart;
    public static $CanNotEmailChart;

    public static $SeriesDelete;

    public static $AsJPEG;
    public static $JPEGFilter;
    public static $AsGIF;
    public static $GIFFilter;
    public static $AsPNG;
    public static $PNGFilter;
    public static $AsPCX;
    public static $PCXFilter;
    public static $AsVML;
    public static $VMLFilter;
    public static $AsTIFF;
    public static $TIFFFilter;

    public static $AskLanguage;

    public static $GalleryContour;
    public static $GalleryBezier;
    public static $GalleryCursor;
    public static $GalleryBigCandle;
    public static $GalleryHistogram;
    public static $GalleryWaterFall;
    public static $GalleryBoxPlot;
    public static $GalleryHorizBoxPlot;
    public static $GallerySmith;
    public static $GalleryMap;

    public static $PolyDegreeRange;
    public static $AnswerVectorIndex;
    public static $FittingError;
    public static $ExpAverageWeight;
    public static $GalleryErrorBar;
    public static $GalleryError;
    public static $GalleryHighLow;
    public static $FunctionMomentum;
    public static $FunctionMomentumDiv;
    public static $FunctionExpAverage;
    public static $FunctionExpMovAve;
    public static $FunctionRSI;
    public static $FunctionCurveFitting;
    public static $FunctionTrend;
    public static $FunctionExpTrend;
    public static $FunctionLogTrend;
    public static $FunctionCumulative;
    public static $FunctionStdDeviation;
    public static $FunctionBollinger;
    public static $FunctionRMS;
    public static $FunctionMACD;
    public static $FunctionStochastic;
    public static $FunctionADX;

    public static $FunctionCount;
    public static $LoadChart;
    public static $SaveChart;

    public static $GallerySamples;
    public static $GalleryStats;

    public static $CannotFindEditor;


    public static $CannotLoadChartFromURL;
    public static $CannotLoadSeriesDataFromURL;

    public static $ValuesDate;
    public static $ValuesOpen;
    public static $ValuesHigh;
    public static $ValuesLow;
    public static $ValuesClose;
    public static $ValuesOffset;
    public static $ValuesStdError;

    public static $Grid3D;

    public static $LowBezierPoints;

    public static $CommanMsgNormal;
    public static $CommanMsgEdit;
    public static $CommanMsgPrint;
    public static $CommanMsgCopy;
    public static $CommanMsgSave;
    public static $CommanMsg3D;

    public static $CommanMsgRotating;
    public static $CommanMsgRotate;

    public static $CommanMsgMoving;
    public static $CommanMsgMove;

    public static $CommanMsgZooming;
    public static $CommanMsgZoom;

    public static $CommanMsgDepthing;
    public static $CommanMsgDepth;

    public static $CommanMsgChart;
    public static $CommanMsgPanel;

    public static $CommanMsgRotateLabel;
    public static $CommanMsgMoveLabel;
    public static $CommanMsgZoomLabel;
    public static $CommanMsgDepthLabel;

    public static $CommanMsgNormalLabel;
    public static $CommanMsgNormalPieLabel;

    public static $CommanMsgPieExploding;

    public static $TriSurfaceLess;
    public static $TriSurfaceAllColinear;
    public static $TriSurfaceSimilar;
    public static $GalleryTriSurface;

    public static $AllSeries;
    public static $Edit;
    public static $DataSource;
    public static $GalleryFinancial;
    public static $CursorTool;
    public static $DragMarksTool;
    public static $AxisArrowTool;
    public static $DrawLineTool;
    public static $NearestTool;
    public static $ColorBandTool;
    public static $ColorLineTool;
    public static $RotateTool;
    public static $ImageTool;
    public static $MarksTipTool;
    public static $AnnotationTool;
    public static $ExtraLegendTool;
    public static $GridBandTool;
    public static $FunctionCompressOHLC;
    public static $FunctionCLV;
    public static $FunctionOBV;
    public static $FunctionCCI;
    public static $FunctionMovingAverage;
    public static $FunctionPVO;
    public static $FunctionPerf;
    public static $GalleryGauge;
    public static $GalleryGauges;
    public static $GalleryVector3D;
    public static $CantDeleteAncestor;
    public static $Load;
    public static $DefaultDemoTee;
    public static $TeeFilesExtension;
    public static $TeeFiles;
    public static $NoSeriesSelected;
    public static $CandleBar;
    public static $CandleNoOpen;
    public static $CandleNoClose;
    public static $NoHigh;
    public static $NoLow;
    public static $ColorRange;
    public static $WireFrame;
    public static $DotFrame;
    public static $Positions;
    public static $NoGrid;
    public static $NoPoint;
    public static $NoLine;
    public static $Labels;
    public static $NoCircle;
    public static $Lines;
    public static $Border;
    public static $SmithResistance;
    public static $SmithReactance;
    public static $Column;
    public static $Separator;
    public static $FunnelSegment;
    public static $FunnelSeries;
    public static $FunnelPercent;
    public static $FunnelExceed;
    public static $FunnelWithin;
    public static $FunnelBelow;
    public static $CalendarSeries;
    public static $DeltaPointSeries;
    public static $ImagePointSeries;
    public static $ImageBarSeries;
    public static $SeriesTextFieldZero;
    public static $Origin;
    public static $Transparency;
    public static $Box;
    public static $ExtrOut;
    public static $MildOut;
    public static $PageNumber;
    public static $TextFile;
    public static $Gradient;
    public static $DragPoint;
    public static $TabDelimiter = "\t";
    public static $QuoteValues;
    public static $OpportunityValues;
    public static $DesignFolderNotFound;
    public static $AsPDF;
    public static $PDFFilter;
    public static $AsPS;
    public static $PSFilter;
    public static $HorizAreaSeries;
    public static $SelectFolder;
    public static $ADOConnection;
    public static $SelfStack;
    public static $DarkPen;
    public static $FunctionSmooth;
    public static $FunctionCross;
    public static $GridTranspose;
    public static $FunctionCompress;
    public static $SeriesAnimTool;
    public static $GalleryPointFigure;
    public static $Up;
    public static $Down;
    public static $GanttTool;
    public static $XMLFile;
    public static $ValuesVectorEndZ;
    public static $Gallery3D;
    public static $GalleryTower;
    public static $SingleColor;
    public static $Cover;
    public static $Cone;
    public static $PieTool;
    public static $FunctionCustom;
    public static $Property;
    public static $Value;
    public static $Yes;
    public static $No;
    public static $Image;
    public static $Test;
    public static $Confirm;
    public static $SelectPictureFile;
    public static $AllPictureFilter;
    public static $AllFilesFilter;
    public static $TextSrcURL;
    public static $ImageToolSummary;
    public static $ChartImageSummary;
    public static $CursorToolSummary;
    public static $DragMarksSummary;
    public static $DragPointSummary;
    public static $DrawLineSummary;
    public static $ExtraLegendSummary;
    public static $GanttToolSummary;
    public static $MarksTipSummary;
    public static $NearestPointSummary;
    public static $PieToolSummary;
    public static $SeriesAnimationSummary;
    public static $AxisArrowSummary;
    public static $ColorBandSummary;
    public static $ColorLineSummary;
    public static $GridBandSummary;
    public static $GridTransposeSummary;
    public static $AnnotationSummary;
    public static $RotateSummary;
    public static $AsSVG;
    public static $FunctionDownSampling;
    public static $FunctionCorrelation;
    public static $FunctionVariance;
    public static $FunctionPerimeter;
    public static $Color;
    public static $EditPen;
    public static $MapSeries;
    public static $ClassicTheme;
    public static $Current;
    public static $DepthTopAxis;
}
?>
