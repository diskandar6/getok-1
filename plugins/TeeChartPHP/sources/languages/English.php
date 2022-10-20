<?php
 /**
 * Description:  This file contains the following class:<br>
 * English class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 *
 * Title: English class
 *
 * <p>Description: English Constants.</p>
 *
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage languages
 * @link http://www.steema.com
*/

class English extends Texts {
    static public $textsOk = false;

    public function __construct() {
    }

    static public function activate() {
      //  $this->translator = null;
      //  $this->setTexts();
    }


    public static function setTexts() {
        Texts::$languageCode=0;
        Texts::$LegendFirstValue = "First Legend Value must be > 0";
        Texts::$LegendColorWidth = "Legend Color Width must be > 0%";
        Texts::$SeriesSetDataSource = "No ParentChart to validate DataSource";
        Texts::$SeriesInvDataSource = "No valid DataSource: {0}";
        Texts::$FillSample = "FillSampleValues NumValues must be > 0";
        Texts::$AxisLogDateTime = "DateTime Axis cannot be Logarithmic";
        Texts::$AxisLogNotPositive =
                "Logarithmic Axis Min and Max values should be >= 0";
        Texts::$AxisLabelSep = "Labels Separation % must be greater than 0";
        Texts::$AxisIncrementNeg = "Axis increment must be >= 0";
        Texts::$AxisMinMax = "Axis Minimum Value must be <= Maximum";
        Texts::$AxisMaxMin = "Axis Maximum Value must be >= Minimum";
        Texts::$AxisLogBase = "Axis Logarithmic Base should be >= 2";
        Texts::$MaxPointsPerPage = "MaxPointsPerPage must be >= 0";
        Texts::$Percent3D = "3D effect percent must be between {0} and {1}";
        Texts::$CircularSeries = "Circular Series dependences are not allowed";
        Texts::$WarningHIColor = "16k Color or greater required to get better look";
        Texts::$DefaultPercentOf = "{0} of {1}";
        Texts::$DefaultPercentOf2 = "{0} \r of {1}";
        Texts::$AxisTitle = "Axis Title";
        Texts::$AxisLabels = "Axis Labels";
        Texts::$RefreshInterval = "Refresh Interval must be between 0 and 60";
        Texts::$SeriesParentNoSelf = "Series.ParentChart is not myself!";
        Texts::$GalleryLine = "Line";
        Texts::$GalleryPoint = "Point";
        Texts::$GalleryArea = "Area";
        Texts::$GalleryBar = "Bar";
        Texts::$GalleryBar3D = "Bar 3D";
        Texts::$GalleryHorizBar = "Horiz. Bar";
        Texts::$Stack = "Stack";
        Texts::$GalleryPie = "Pie";
        Texts::$GalleryCandle = "Candle";
        Texts::$GalleryCircled = "Circled";
        Texts::$GalleryFastLine = "Fast Line";
        Texts::$GalleryHorizLine = "Horiz Line";

        Texts::$PieSample1 = "Cars";
        Texts::$PieSample2 = "Phones";
        Texts::$PieSample3 = "Tables";
        Texts::$PieSample4 = "Monitors";
        Texts::$PieSample5 = "Lamps";
        Texts::$PieSample6 = "Keyboards";
        Texts::$PieSample7 = "Bikes";
        Texts::$PieSample8 = "Chairs";

        Texts::$GalleryLogoFont = "Courier New";
        Texts::$Editing = "Editing {0}";

        Texts::$GalleryStandard = "Standard";
        Texts::$GalleryExtended = "Extended";
        Texts::$GalleryFunctions = "Functions";

        Texts::$EditChart = "E&dit Chart...";
        Texts::$Options = "&Options...";
        Texts::$OnlineSupport = "Online &Support...";
        Texts::$PrintPreview = "&Print Preview...";
        Texts::$ExportChart = "E&xport Chart...";
        Texts::$ImportChart = "&Import Chart...";
        Texts::$CustomAxes = "Custom Axes...";

        Texts::$InvalidEditorClass = "{0}: Invalid Editor Class: {1}";
        Texts::$MissingEditorClass = "{0}: has no Editor Dialog";

        Texts::$GalleryArrow = "Arrow";

        Texts::$ExpFinish = "&Finish";
        Texts::$ExpNext = "&Next >";

        Texts::$GalleryGantt = "Gantt";

        Texts::$GanttSample1 = "Design";
        Texts::$GanttSample2 = "Prototyping";
        Texts::$GanttSample3 = "Development";
        Texts::$GanttSample4 = "Sales";
        Texts::$GanttSample5 = "Marketing";
        Texts::$GanttSample6 = "Testing";
        Texts::$GanttSample7 = "Manufac.";
        Texts::$GanttSample8 = "Debugging";
        Texts::$GanttSample9 = "New Version";
        Texts::$GanttSample10 = "Banking";

        Texts::$ChangeSeriesTitle = "Change Series Title";
        Texts::$NewSeriesTitle = "New Series Title:";
        Texts::$DateTime = "DateTime";
        Texts::$TopAxis = "Top Axis";
        Texts::$BottomAxis = "Bottom Axis";
        Texts::$LeftAxis = "Left Axis";
        Texts::$RightAxis = "Right Axis";

        Texts::$SureToDelete = "Delete {0} ?";
        Texts::$DateTimeFormat = "DateTime For&mat:";
        Texts::$Default = "Default: ";
        Texts::$ValuesFormat = "Values For&mat:";
        Texts::$Maximum = "Maximum";
        Texts::$Minimum = "Minimum";
        Texts::$DesiredIncrement = "Desired {0} Increment";

        Texts::$IncorrectMaxMinValue = "Incorrect value. Reason: {0}";
        Texts::$EnterDateTime = "Enter [Number of Days] [hh:mm:ss]";

        Texts::$SureToApply = "Apply Changes ?";
        Texts::$SelectedSeries = "(Selected Series)";
        Texts::$RefreshData = "&Refresh Data";

        Texts::$DefaultFontSize = "8";
        Texts::$DefaultEditorSize = "414";
        Texts::$DefaultEditorHeight = "347";
        Texts::$TabDelimiter = "\t";

        Texts::$FunctionAdd = "Add";
        Texts::$FunctionSubtract = "Subtract";
        Texts::$FunctionMultiply = "Multiply";
        Texts::$FunctionDivide = "Divide";
        Texts::$FunctionHigh = "High";
        Texts::$FunctionLow = "Low";
        Texts::$FunctionAverage = "Average";

        Texts::$GalleryShape = "Shape";
        Texts::$GalleryBubble = "Bubble";
        Texts::$GalleryBarJoin = "Bar Join";
        Texts::$GalleryDonut = "Donut";
        Texts::$GalleryPolar = "Polar";
        Texts::$GalleryRadar = "Radar";
        Texts::$GalleryVolume = "Volume";
        Texts::$GalleryPoint3D = "Point 3D";
        Texts::$GalleryPyramid = "Pyramid";
        Texts::$GalleryWindRose = "Wind Rose";
        Texts::$GalleryClock = "Clock";
        Texts::$GalleryLinePoint = "Line Point";
        Texts::$GallerySurface = "Surface";
        Texts::$GalleryColorGrid = "ColorGrid";

        Texts::$FunctionNone = "Copy";
        Texts::$AxisDlgValue = "Value:";

        Texts::$None = "(none)";

        Texts::$DefaultFontName = "Arial";

        Texts::$CheckPointerSize = "Pointer size must be greater than zero";
        Texts::$About = "Abo&ut steema.teechart...";

        Texts::$DataSet = "Dataset";
        Texts::$AskDataSet = "&Dataset:";

        Texts::$SingleRecord = "Single Record";
        Texts::$AskDataSource = "&DataSource:";

        Texts::$Summary = "Summary";

        Texts::$FunctionPeriod = "Function Period should be >= 0";

        Texts::$WizardTab = "Business";
        Texts::$ChartWizard = "TeeChart Wizard";

        Texts::$ClearImage = "Clear";
        Texts::$BrowseImage = "Browse...";

        Texts::$WizardSureToClose =
                "Are you sure that you want to close the TeeChart Wizard ?";
        Texts::$FieldNotFound = "Field {0} does not exist";

        Texts::$DepthAxis = "Depth Axis";
        Texts::$PieOther = "Other";
        Texts::$ShapeGallery1 = "abc";
        Texts::$ShapeGallery2 = "123";
        Texts::$ValuesPie = "Pie";
        Texts::$ValuesBar = "Bar";
        Texts::$ValuesAngle = "Angle";
        Texts::$ValuesGanttStart = "Start";
        Texts::$ValuesGanttEnd = "End";
        Texts::$ValuesGanttNextTask = "NextTask";
        Texts::$ValuesBubbleRadius = "Radius";
        Texts::$ValuesArrowEndX = "EndX";
        Texts::$ValuesArrowEndY = "EndY";
        Texts::$Legend = "Legend";
        Texts::$Title = "Title";
        Texts::$Foot = "Footer";
        Texts::$Period = "Period";
        Texts::$PeriodRange = "Period range";
        Texts::$CalcPeriod = "Calculate {0} every:";
        Texts::$SmallDotsPen = "Small Dots";

        Texts::$InvalidTeeFile = "Invalid Chart in *.ten file";
        Texts::$WrongTeeFileFormat = "Wrong *.ten file format";
        Texts::$EmptyTeeFile = "Empty *.ten file";

        Texts::$CustomAxesEditor = "Custom ";
        Texts::$Series = "Series";
        Texts::$SeriesList = "Series...";

        Texts::$PageOfPages = "Page {0} de {1}"; //"Page %1$1s of %2$1s"; for String.format
        Texts::$FileSize = "{0} bytes";

        Texts::$First = "First";
        Texts::$Prior = "Prior";
        Texts::$Next = "Next";
        Texts::$Last = "Last";
        Texts::$Insert = "Insert";
        Texts::$Delete = "Delete";
        Texts::$Post = "Post";
        Texts::$Cancel = "Cancel";

        Texts::$All = "(all)";
        Texts::$Index = "Index";
        Texts::$Text = "Text";

        Texts::$AsBMP = "as Bitmap";
        Texts::$BMPFilter = "Bitmaps (*.bmp)|*.bmp";
        Texts::$AsEMF = "as Metafile";
        Texts::$EMFFilter = "Enhanced Metafiles (*.emf)|*.emf|Metafiles (*.wmf)|*.wmf";
        Texts::$WMFFilter = "Metafiles (*.wmf)|*.wmf|Enhanced Metafiles (*.emf)|*.emf";
        Texts::$ExportPanelNotSet = "Panel property is not set in Export format";

        Texts::$TextFilter = "Text files (*.csv;*.txt)|*.csv;*.txt";
        Texts::$XMLFilter = "XML files (*.xml)|*.xml";
        Texts::$ExcelFilter = "Excel files (*.xls)|*.xls";
        Texts::$HTMLFilter = "HTML files (*.htm;*.html)|*.htm;*.html";

        Texts::$Normal = "Normal";
        Texts::$NoBorder = "No Border";
        Texts::$Dotted = "Dotted";
        Texts::$Colors = "Colors";
        Texts::$Filled = "Filled";
        Texts::$Marks = "Marks";
        Texts::$Stairs = "Stairs";
        Texts::$Points = "Points";
        Texts::$Height = "Height";
        Texts::$Hollow = "Hollow";
        Texts::$Point2D = "Point 2D";
        Texts::$Triangle = "Triangle";
        Texts::$Star = "Star";
        Texts::$Circle = "Circle";
        Texts::$DownTri = "Down Tri.";
        Texts::$Cross = "Cross";
        Texts::$Diamond = "Diamond";
        Texts::$NoLines = "No tLines";
        Texts::$Stack100 = "Stack 100%";
        Texts::$Pyramid = "Pyramid";
        Texts::$Ellipse = "Ellipse";
        Texts::$InvPyramid = "Inv. Pyramid";
        Texts::$Sides = "Sides";
        Texts::$SideAll = "Side All";
        Texts::$Patterns = "Patterns";
        Texts::$Exploded = "Exploded";
        Texts::$Shadow = "Shadow";
        Texts::$SemiPie = "Semi Pie";
        Texts::$Rectangle = "Rectangle";
        Texts::$VertLine = "Vert.Line";
        Texts::$HorizLine = "Horiz.Line";
        Texts::$Line = "Line";
        Texts::$Cube = "Cube";
        Texts::$DiagCross = "Diag.Cross";

        Texts::$CanNotFindTempPath = "Can not find Temp folder";
        Texts::$CanNotCreateTempChart = "Can not create Temp file";
        Texts::$CanNotEmailChart = "Can not email steema.teechart. Mapi Error: {0}";

        Texts::$SeriesDelete =
                "Series Delete: ValueIndex {0} out of bounds (0 to {1}).";

        Texts::$AsJPEG = "as JPEG";
        Texts::$JPEGFilter = "JPEG files (*.jpg)|*.jpg";
        Texts::$AsGIF = "as GIF";
        Texts::$GIFFilter = "GIF files (*.gif)|*.gif";
        Texts::$AsPNG = "as PNG";
        Texts::$PNGFilter = "PNG files (*.png)|*.png";
        Texts::$AsPCX = "as PCX";
        Texts::$PCXFilter = "PCX files (*.pcx)|*.pcx";
        Texts::$AsVML = "as VML (HTM)";
        Texts::$VMLFilter = "VML files (*.htm)|*.htm";
        Texts::$AsTIFF = "as TIFF";
        Texts::$TIFFFilter = "TIFF files (*.tif)|*.tif";
        Texts::$AsPDF = "as PDF";
        Texts::$PDFFilter = "PDF files (*.pdf)|*.pdf";
        Texts::$HTMLFilter = "HTML files (*.htm;*.html)|*.htm;*.html";        

        Texts::$AskLanguage = "&Language...";

        // PRO

        Texts::$GalleryContour = "Contour";
        Texts::$GalleryBezier = "Bezier";
        Texts::$GalleryCursor = "Cursor";
        Texts::$GalleryBigCandle = "Big Candle";
        Texts::$GalleryHistogram = "Histogram";
        Texts::$GalleryWaterFall = "Water Fall";
        Texts::$GalleryBoxPlot = "BoxPlot";
        Texts::$GalleryHorizBoxPlot = "Horiz.BoxPlot";
        Texts::$GallerySmith = "Smith";
        Texts::$GalleryMap = "Map";

        Texts::$PolyDegreeRange = "Polynomial degree must be between 1 and 20";
        Texts::$AnswerVectorIndex = "Answer Vector index must be between 1 and {0}";
        Texts::$FittingError = "Cannot process fitting";
        Texts::$ExpAverageWeight = "ExpAverage Weight must be between 0 and 1";
        Texts::$GalleryErrorBar = "Error Bar";
        Texts::$GalleryError = "Error";
        Texts::$GalleryHighLow = "High-Low";
        Texts::$FunctionMomentum = "Momentum";
        Texts::$FunctionMomentumDiv = "Momentum Div";
        Texts::$FunctionExpAverage = "Exp. Average";
        Texts::$FunctionExpMovAve = "Exp.Mov.Avrg.";
        Texts::$FunctionRSI = "R.S.I.";
        Texts::$FunctionCurveFitting = "Curve Fitting";
        Texts::$FunctionTrend = "Trend";
        Texts::$FunctionExpTrend = "Exp.Trend";
        Texts::$FunctionLogTrend = "Log.Trend";
        Texts::$FunctionCumulative = "Cumulative";
        Texts::$FunctionStdDeviation = "Std.Deviation";
        Texts::$FunctionBollinger = "Bollinger";
        Texts::$FunctionRMS = "Root Mean Sq.";
        Texts::$FunctionMACD = "MACD";
        Texts::$FunctionStochastic = "Stochastic";
        Texts::$FunctionADX = "ADX";

        Texts::$FunctionCount = "Count";
        Texts::$LoadChart = "Open steema.teechart...";
        Texts::$SaveChart = "Save steema.teechart...";

        Texts::$GallerySamples = "Other";
        Texts::$GalleryStats = "Stats";

        Texts::$CannotFindEditor = "Cannot find Series editor Form: {0}";

        Texts::$CannotLoadChartFromURL =
                "Error code: {0} downloading Chart from URL: {1}";
        Texts::$CannotLoadSeriesDataFromURL =
                "Error code: {0} downloading Series data from URL: {1}";

        Texts::$ValuesDate = "Date";
        Texts::$ValuesOpen = "Open";
        Texts::$ValuesHigh = "High";
        Texts::$ValuesLow = "Low";
        Texts::$ValuesClose = "Close";
        Texts::$ValuesOffset = "Offset";
        Texts::$ValuesStdError = "StdError";

        Texts::$Grid3D = "Grid 3D";

        Texts::$LowBezierPoints = "Number of Bezier points should be > 1";

        // TeeCommander component

        Texts::$CommanMsgNormal = "Normal";
        Texts::$CommanMsgEdit = "Edit";
        Texts::$CommanMsgPrint = "Print";
        Texts::$CommanMsgCopy = "Copy";
        Texts::$CommanMsgSave = "Save";
        Texts::$CommanMsg3D = "3D";

        Texts::$CommanMsgRotating = "Rotation: {0} Elevation: {1}";
        Texts::$CommanMsgRotate = "Rotate";

        Texts::$CommanMsgMoving = "Horiz.Offset: {0} Vert.Offset: {1}";
        Texts::$CommanMsgMove = "Move";

        Texts::$CommanMsgZooming = "Zoom: {0}%";
        Texts::$CommanMsgZoom = "Zoom";

        Texts::$CommanMsgDepthing = "3D: {0}%";
        Texts::$CommanMsgDepth = "Depth";

        Texts::$CommanMsgChart = "Chart";
        Texts::$CommanMsgPanel = "Panel";

        Texts::$CommanMsgRotateLabel = "Drag {0} to Rotate";
        Texts::$CommanMsgMoveLabel = "Drag {0} to Move";
        Texts::$CommanMsgZoomLabel = "Drag {0} to Zoom";
        Texts::$CommanMsgDepthLabel = "Drag {0} to resize 3D";

        Texts::$CommanMsgNormalLabel =
                "Drag Left button to Zoom, Right button to Scroll";
        Texts::$CommanMsgNormalPieLabel = "Drag a Pie Slice to Explode it";

        Texts::$CommanMsgPieExploding = "Slice: {0} Exploded: {1} %%";

        Texts::$TriSurfaceLess = "Number of points must be >= 4";
        Texts::$TriSurfaceAllColinear = "All colinear data points";
        Texts::$TriSurfaceSimilar = "Similar points - cannot execute";
        Texts::$GalleryTriSurface = "Triangle Surf.";

        Texts::$AllSeries = "All Series";
        Texts::$Edit = "Edit...";
        Texts::$DataSource = "Data source...";

        Texts::$GalleryFinancial = "Financial";

        Texts::$CursorTool = "Cursor";
        Texts::$DragMarksTool = "Drag Marks";
        Texts::$AxisArrowTool = "Axis Arrows";
        Texts::$DrawLineTool = "Draw Line";
        Texts::$NearestTool = "Nearest Point";
        Texts::$ColorBandTool = "Color Band";
        Texts::$ColorLineTool = "Color Line";
        Texts::$RotateTool = "Rotate";
        Texts::$ImageTool = "Image";
        Texts::$MarksTipTool = "Mark Tips";
        Texts::$AnnotationTool = "Annotation";
        //CDI ExtraLegendTool
        Texts::$ExtraLegendTool = "Extra Legend";
        //CDI GridBand
        Texts::$GridBandTool = "Grid Band";
        //CDI CompressOHLC
        Texts::$FunctionCompressOHLC = "CompressOHLC";
        //CDI CLV
        Texts::$FunctionCLV = "CLV";
        //CDI OBV
        Texts::$FunctionOBV = "On Balance Volume";
        //CDI CCI
        Texts::$FunctionCCI = "CCI";
        //CDI MovingAverage
        Texts::$FunctionMovingAverage = "Moving Average";
        //CDI PVO
        Texts::$FunctionPVO = "Volume Oscillator";
        //CDI Performance
        Texts::$FunctionPerf = "Performance";
        //CDI GaugesSeries
        Texts::$GalleryGauge = "Gauge";
        Texts::$GalleryGauges = "Gauges";
        //CDI Vector3DSeries
        Texts::$GalleryVector3D = "Vector 3D";

        Texts::$CantDeleteAncestor = "Can not delete ancestor";

        Texts::$Load = "Load...";
        Texts::$DefaultDemoTee = "http://www.steema.com/demo.tej";

        Texts::$TeeFilesExtension = "tej";
        Texts::$TeeFiles = "TeeChart Pro files";

        Texts::$NoSeriesSelected = "No Series selected";

        Texts::$CandleBar = "Bar";
        Texts::$CandleNoOpen = "No Open";
        Texts::$CandleNoClose = "No Close";
        Texts::$NoHigh = "No High";
        Texts::$NoLow = "No Low";
        Texts::$ColorRange = "Color Range";
        Texts::$WireFrame = "Wireframe";
        Texts::$DotFrame = "Dot Frame";
        Texts::$Positions = "Positions";
        Texts::$NoGrid = "No Grid";
        Texts::$NoPoint = "No Point";
        Texts::$NoLine = "No Line";
        Texts::$Labels = "Labels";
        Texts::$NoCircle = "No Circle";
        Texts::$Lines = "Lines";
        Texts::$Border = "Border";

        Texts::$SmithResistance = "Resistance";
        Texts::$SmithReactance = "Reactance";

        Texts::$Column = "Column";

        // 5.01
        Texts::$Separator = "Separator";
        Texts::$FunnelSegment = "Segment ";
        Texts::$FunnelSeries = "Funnel";
        Texts::$FunnelPercent = "0.00 %";
        Texts::$FunnelExceed = "Exceeds quota";
        Texts::$FunnelWithin = " within quota";
        Texts::$FunnelBelow = " or more below quota";
        Texts::$CalendarSeries = "Calendar";
        Texts::$DeltaPointSeries = "DeltaPoint";
        Texts::$ImagePointSeries = "ImagePoint";
        Texts::$ImageBarSeries = "ImageBar";
        Texts::$SeriesTextFieldZero =
                "SeriesText: Field index should be greater than zero.";

        // 5.02
        Texts::$Origin = "Origin";
        Texts::$Transparency = "Transparency";
        Texts::$Box = "Box";
        Texts::$ExtrOut = "ExtrOut";
        Texts::$MildOut = "MildOut";
        Texts::$PageNumber = "Page Number";
        Texts::$TextFile = "Text File";

        // 5.03
        Texts::$Gradient = "Gradient";
        Texts::$DragPoint = "Drag Point";

        Texts::$QuoteValues = "QuoteValues";
        Texts::$OpportunityValues = "OpportunityValues";

        //Web messages
        Texts::$DesignFolderNotFound = "Cannot locate project folder";

        // 6.0
        Texts::$AsPS = "as PostScript";
        Texts::$PSFilter = "PostScript files (*.eps)|*.eps";
        Texts::$HorizAreaSeries = "Horizontal Area";
        Texts::$SelectFolder = "Select folder with database";
        Texts::$ADOConnection = "&Connection:";

        Texts::$SelfStack = "Self Stacked";
        Texts::$DarkPen = "Dark Border";
        Texts::$FunctionSmooth = "Smoothing";
        Texts::$FunctionCross = "Cross Points";
        Texts::$GridTranspose = "3D Grid Transpose";
        Texts::$FunctionCompress = "Compression";
        Texts::$ExtraLegendTool = "Extra Legend";
        Texts::$SeriesAnimTool = "Series Animation";
        Texts::$GalleryPointFigure = "Point & Figure";
        Texts::$Up = "Up";
        Texts::$Down = "Down";
        Texts::$GanttTool = "Gantt Drag";
        Texts::$XMLFile = "XML file";
        Texts::$ValuesVectorEndZ = "EndZ";
        Texts::$Gallery3D = "3D";
        Texts::$GalleryTower = "Tower";
        Texts::$SingleColor = "Single Color";
        Texts::$Cover = "Cover";
        Texts::$Cone = "Cone";
        Texts::$PieTool = "Pie Slices";
        Texts::$FunctionCustom = "y=f(x)";

        Texts::$Property = "Property";
        Texts::$Value = "Value";
        Texts::$Yes = "Yes";
        Texts::$No = "No";
        Texts::$Image = "(image)";
        Texts::$Test = "Test...";

        Texts::$Confirm = "Confirm";

        // v1.1
        Texts::$SelectPictureFile = "Select picture file to open...";
        Texts::$AllPictureFilter =
                "All picture files|*.bmp;*.gif;*.jpg;*.jpeg;*.png;*.tif";
        Texts::$AllFilesFilter = "All files (*.*)|*.*";

        //May 2004
        Texts::$TextSrcURL = "http://www.steema.com/test.txt";
        Texts::$ImageToolSummary = Texts::$ChartImageDesc;
        Texts::$CursorToolSummary = Texts::$CursorToolDesc;
        Texts::$DragMarksSummary = Texts::$DragMarksDesc;
        Texts::$DragPointSummary = Texts::$DragPointDesc;
        Texts::$DrawLineSummary = Texts::$DrawLineDesc;
        Texts::$ExtraLegendSummary = Texts::$ExtraLegendDesc;
        Texts::$GanttToolSummary = Texts::$GanttToolDesc;
        Texts::$MarksTipSummary = Texts::$MarksTipDesc;
        Texts::$NearestPointSummary = Texts::$NearestPointDesc;
        Texts::$PieToolSummary = Texts::$PieToolDesc;
        Texts::$SeriesAnimationSummary = Texts::$SeriesAnimationDesc;
        Texts::$AxisArrowSummary = Texts::$AxisArrowDesc;
        Texts::$ColorBandSummary = Texts::$ColorBandDesc;
        Texts::$ColorLineSummary = Texts::$ColorLineDesc;
        Texts::$GridBandSummary = Texts::$GridBandDesc;
        Texts::$GridTransposeSummary = Texts::$GridTransposeDesc;
        Texts::$AnnotationSummary = Texts::$AnnotationDesc;
        Texts::$RotateSummary = Texts::$RotateDesc;

        // June 2004
        Texts::$AsSVG = "as SVG (SVG)";
        Texts::$SVGFilter = "SVG files (*.svg)|*.svg";
        Texts::$FunctionDownSampling = "Downsampling";

        // september 2004
        Texts::$FunctionCorrelation = "Correlation";
        Texts::$FunctionVariance = "Variance";
        Texts::$FunctionPerimeter = "Perimeter";

        Texts::$Color = "Color...";
        Texts::$EditPen = "Pen...";

        // Post 0.99

        Texts::$MapSeries = "Map";
        Texts::$ClassicTheme = "Classic";
        Texts::$Current = "Current";

        // may 2006

        Texts::$DepthTopAxis= "Depth Top";

        English::$textsOk = true;
    }
}
?>