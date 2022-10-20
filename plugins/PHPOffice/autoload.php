<?php
/*

help    >>>     https://github.com/PHPOffice/PhpSpreadsheet/tree/master/docs/topics
                https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/#add-a-drawing-to-a-worksheet

//==============================================================================

$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];

$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);



    left
    right
    top
    bottom
    diagonal


    allBorders
    outline
    inside
    vertical
    horizontal

//==============================================================================

$spreadsheet->getActiveSheet()->mergeCells('A18:E22');
$spreadsheet->getActiveSheet()->unmergeCells('A18:E22');

//==============================================================================

$spreadsheet->getActiveSheet()->getStyle('A1')->getNumberFormat()
    ->setFormatCode('#,##0.00');


$spreadsheet->getActiveSheet()->getStyle('A1')->getNumberFormat()
    ->setFormatCode('[Blue][>=3000]$#,##0;[Red][<0]$#,##0;$#,##0');

$spreadsheet->getActiveSheet()->getCell('A1')->setValue(19);
$spreadsheet->getActiveSheet()->getStyle('A1')->getNumberFormat()
    ->setFormatCode('0000'); // will show as 0019 in Excel


//==============================================================================

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath('./images/officelogo.jpg');
$drawing->setHeight(36);
--------------------------------------------------------------------------------
$drawing->setName('Paid');
$drawing->setDescription('Paid');
$drawing->setPath('./images/paid.png');
$drawing->setCoordinates('B15');
$drawing->setOffsetX(110);
$drawing->setRotation(25);
$drawing->getShadow()->setVisible(true);
$drawing->getShadow()->setDirection(45);
--------------------------------------------------------------------------------
//  Use GD to create an in-memory image
$gdImage = @imagecreatetruecolor(120, 20) or die('Cannot Initialize new GD image stream');
$textColor = imagecolorallocate($gdImage, 255, 255, 255);
imagestring($gdImage, 1, 5, 5,  'Created with PhpSpreadsheet', $textColor);

//  Add the In-Memory image to a worksheet
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
$drawing->setName('In-Memory image 1');
$drawing->setDescription('In-Memory image 1');
$drawing->setCoordinates('A1');
$drawing->setImageResource($gdImage);
$drawing->setRenderingFunction(
    \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG
);
$drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
$drawing->setHeight(36);
$drawing->setWorksheet($spreadsheet->getActiveSheet());
*/

$dir=__DIR__.'/php-enum-master/src/';
//scandir__($dir,$dir);
require $dir.'Enum.php';
//require $dir.'PHPUnit/Comparator.php';


$dir=__DIR__.'/http-message-master/src/';
require $dir.'MessageInterface.php';
require $dir.'RequestInterface.php';
require $dir.'ResponseInterface.php';
require $dir.'ServerRequestInterface.php';
require $dir.'StreamInterface.php';
require $dir.'UploadedFileInterface.php';
require $dir.'UriInterface.php';

$dir=__DIR__.'/ZipStream-PHP-master/src/';

require $dir.'Bigint.php';
require $dir.'Exception.php';
require $dir.'File.php';
require $dir.'Stream.php';
require $dir.'DeflateStream.php';
require $dir.'ZipStream.php';

require $dir.'Exception/EncodingException.php';
require $dir.'Exception/FileNotFoundException.php';
require $dir.'Exception/FileNotReadableException.php';
require $dir.'Exception/IncompatibleOptionsException.php';
require $dir.'Exception/OverflowException.php';
require $dir.'Exception/StreamNotReadableException.php';

require $dir.'Option/Archive.php';
require $dir.'Option/File.php';
require $dir.'Option/Method.php';
require $dir.'Option/Version.php';

$dir=__DIR__.'/simple-cache-master/src/';
require $dir.'CacheException.php';
require $dir.'CacheInterface.php';
require $dir.'InvalidArgumentException.php';

$dir=__DIR__.'/PhpSpreadsheet-master/src/PhpSpreadsheet/';

require $dir.'IComparable.php';
require $dir.'Comment.php';
require $dir.'DefinedName.php';
require $dir.'DocumentGenerator.php';
require $dir.'Exception.php';
require $dir.'HashTable.php';
require $dir.'IOFactory.php';
require $dir.'NamedFormula.php';
require $dir.'NamedRange.php';
require $dir.'ReferenceHelper.php';
require $dir.'Settings.php';
require $dir.'Spreadsheet.php';

require $dir.'Calculation/Calculation.php';
require $dir.'Calculation/Category.php';
require $dir.'Calculation/Database.php';
require $dir.'Calculation/DateTime.php';
require $dir.'Calculation/Engineering.php';
require $dir.'Calculation/Exception.php';
require $dir.'Calculation/ExceptionHandler.php';
require $dir.'Calculation/Financial.php';
require $dir.'Calculation/FormulaParser.php';
require $dir.'Calculation/FormulaToken.php';
require $dir.'Calculation/Functions.php';
require $dir.'Calculation/Logical.php';
require $dir.'Calculation/LookupRef.php';
require $dir.'Calculation/MathTrig.php';
require $dir.'Calculation/Statistical.php';
require $dir.'Calculation/TextData.php';
require $dir.'Calculation/Web.php';
//require $dir.'Calculation/functionlist.txt';
require $dir.'Calculation/Engine/CyclicReferenceStack.php';
require $dir.'Calculation/Engine/Logger.php';
require $dir.'Calculation/Token/Stack.php';
/*require $dir.'Calculation/locale/bg/config';
require $dir.'Calculation/locale/bg/functions';
require $dir.'Calculation/locale/cs/config';
require $dir.'Calculation/locale/cs/functions';
require $dir.'Calculation/locale/da/config';
require $dir.'Calculation/locale/da/functions';
require $dir.'Calculation/locale/de/config';
require $dir.'Calculation/locale/de/functions';
require $dir.'Calculation/locale/en/uk/config';
require $dir.'Calculation/locale/es/config';
require $dir.'Calculation/locale/es/functions';
require $dir.'Calculation/locale/fi/config';
require $dir.'Calculation/locale/fi/functions';
require $dir.'Calculation/locale/fr/config';
require $dir.'Calculation/locale/fr/functions';
require $dir.'Calculation/locale/hu/config';
require $dir.'Calculation/locale/hu/functions';
require $dir.'Calculation/locale/it/config';
require $dir.'Calculation/locale/it/functions';
require $dir.'Calculation/locale/nl/config';
require $dir.'Calculation/locale/nl/functions';
require $dir.'Calculation/locale/no/config';
require $dir.'Calculation/locale/no/functions';
require $dir.'Calculation/locale/pl/config';
require $dir.'Calculation/locale/pl/functions';
require $dir.'Calculation/locale/pt/config';
require $dir.'Calculation/locale/pt/functions';
require $dir.'Calculation/locale/pt/br/config';
require $dir.'Calculation/locale/pt/br/functions';
require $dir.'Calculation/locale/ru/config';
require $dir.'Calculation/locale/ru/functions';
require $dir.'Calculation/locale/sv/config';
require $dir.'Calculation/locale/sv/functions';
require $dir.'Calculation/locale/tr/config';
require $dir.'Calculation/locale/tr/functions';*/
require $dir.'Cell/AddressHelper.php';

require $dir.'Cell/IValueBinder.php';
require $dir.'Cell/DefaultValueBinder.php';
require $dir.'Cell/AdvancedValueBinder.php';

require $dir.'Cell/Cell.php';
require $dir.'Cell/Coordinate.php';
require $dir.'Cell/DataType.php';
require $dir.'Cell/DataValidation.php';
require $dir.'Cell/DataValidator.php';
require $dir.'Cell/Hyperlink.php';
require $dir.'Cell/StringValueBinder.php';

require $dir.'Chart/Properties.php';
require $dir.'Chart/Axis.php';
require $dir.'Chart/Chart.php';
require $dir.'Chart/DataSeries.php';
require $dir.'Chart/DataSeriesValues.php';
require $dir.'Chart/Exception.php';
require $dir.'Chart/GridLines.php';
require $dir.'Chart/Layout.php';
require $dir.'Chart/Legend.php';
require $dir.'Chart/PlotArea.php';
require $dir.'Chart/Title.php';
require $dir.'Chart/Renderer/IRenderer.php';
require $dir.'Chart/Renderer/JpGraph.php';
//require $dir.'Chart/Renderer/PHP Charting Libraries.txt';

require $dir.'Collection/Cells.php';
require $dir.'Collection/CellsFactory.php';
require $dir.'Collection/Memory.php';

require $dir.'Document/Properties.php';
require $dir.'Document/Security.php';
require $dir.'Helper/Html.php';
require $dir.'Helper/Sample.php';

require $dir.'Reader/IReader.php';
require $dir.'Reader/BaseReader.php';
require $dir.'Reader/Csv.php';
require $dir.'Reader/IReadFilter.php';
require $dir.'Reader/DefaultReadFilter.php';
require $dir.'Reader/Exception.php';
require $dir.'Reader/Gnumeric.php';
require $dir.'Reader/Html.php';
require $dir.'Reader/Ods.php';
require $dir.'Reader/Slk.php';
require $dir.'Reader/Xls.php';
require $dir.'Reader/Xlsx.php';
require $dir.'Reader/Xml.php';
require $dir.'Reader/Gnumeric/PageSetup.php';
require $dir.'Reader/Ods/PageSettings.php';
require $dir.'Reader/Ods/Properties.php';
require $dir.'Reader/Security/XmlScanner.php';
require $dir.'Reader/Xls/Color.php';
require $dir.'Reader/Xls/ErrorCode.php';
require $dir.'Reader/Xls/Escher.php';
require $dir.'Reader/Xls/MD5.php';
require $dir.'Reader/Xls/RC4.php';
require $dir.'Reader/Xls/Color/BIFF5.php';
require $dir.'Reader/Xls/Color/BIFF8.php';
require $dir.'Reader/Xls/Color/BuiltIn.php';
require $dir.'Reader/Xls/Style/Border.php';
require $dir.'Reader/Xls/Style/FillPattern.php';
require $dir.'Reader/Xlsx/AutoFilter.php';
require $dir.'Reader/Xlsx/BaseParserClass.php';
require $dir.'Reader/Xlsx/Chart.php';
require $dir.'Reader/Xlsx/ColumnAndRowAttributes.php';
require $dir.'Reader/Xlsx/ConditionalStyles.php';
require $dir.'Reader/Xlsx/DataValidations.php';
require $dir.'Reader/Xlsx/Hyperlinks.php';
require $dir.'Reader/Xlsx/PageSetup.php';
require $dir.'Reader/Xlsx/Properties.php';
require $dir.'Reader/Xlsx/SheetViewOptions.php';
require $dir.'Reader/Xlsx/SheetViews.php';
require $dir.'Reader/Xlsx/Styles.php';
require $dir.'Reader/Xlsx/Theme.php';
require $dir.'Reader/Xml/PageSettings.php';

require $dir.'RichText/ITextElement.php';
require $dir.'RichText/RichText.php';
require $dir.'RichText/TextElement.php';
require $dir.'RichText/Run.php';

require $dir.'Shared/CodePage.php';
require $dir.'Shared/Date.php';
require $dir.'Shared/Drawing.php';
require $dir.'Shared/Escher.php';
require $dir.'Shared/File.php';
require $dir.'Shared/Font.php';
require $dir.'Shared/OLE.php';
require $dir.'Shared/OLERead.php';
require $dir.'Shared/PasswordHasher.php';
require $dir.'Shared/StringHelper.php';
require $dir.'Shared/TimeZone.php';
require $dir.'Shared/XMLWriter.php';
require $dir.'Shared/Xls.php';
require $dir.'Shared/Escher/DgContainer.php';
require $dir.'Shared/Escher/DggContainer.php';
require $dir.'Shared/Escher/DgContainer/SpgrContainer.php';
require $dir.'Shared/Escher/DgContainer/SpgrContainer/SpContainer.php';
require $dir.'Shared/Escher/DggContainer/BstoreContainer.php';
require $dir.'Shared/Escher/DggContainer/BstoreContainer/BSE.php';
require $dir.'Shared/Escher/DggContainer/BstoreContainer/BSE/Blip.php';
//require $dir.'Shared/JAMA/CHANGELOG.TXT';
require $dir.'Shared/JAMA/CholeskyDecomposition.php';
require $dir.'Shared/JAMA/EigenvalueDecomposition.php';
require $dir.'Shared/JAMA/LUDecomposition.php';
require $dir.'Shared/JAMA/Matrix.php';
require $dir.'Shared/JAMA/QRDecomposition.php';
require $dir.'Shared/JAMA/SingularValueDecomposition.php';
require $dir.'Shared/JAMA/utils/Maths.php';
require $dir.'Shared/OLE/ChainedBlockStream.php';
require $dir.'Shared/OLE/PPS.php';
require $dir.'Shared/OLE/PPS/File.php';
require $dir.'Shared/OLE/PPS/Root.php';
require $dir.'Shared/Trend/BestFit.php';
require $dir.'Shared/Trend/ExponentialBestFit.php';
require $dir.'Shared/Trend/LinearBestFit.php';
require $dir.'Shared/Trend/LogarithmicBestFit.php';
require $dir.'Shared/Trend/PolynomialBestFit.php';
require $dir.'Shared/Trend/PowerBestFit.php';
require $dir.'Shared/Trend/Trend.php';

require $dir.'Style/Supervisor.php';
require $dir.'Style/Alignment.php';
require $dir.'Style/Border.php';
require $dir.'Style/Borders.php';
require $dir.'Style/Color.php';
require $dir.'Style/Conditional.php';
require $dir.'Style/Fill.php';
require $dir.'Style/Font.php';
require $dir.'Style/NumberFormat.php';
require $dir.'Style/Protection.php';
require $dir.'Style/Style.php';

require $dir.'Worksheet/AutoFilter.php';
require $dir.'Worksheet/BaseDrawing.php';
require $dir.'Worksheet/CellIterator.php';
require $dir.'Worksheet/Column.php';
require $dir.'Worksheet/ColumnCellIterator.php';
require $dir.'Worksheet/Dimension.php';
require $dir.'Worksheet/ColumnDimension.php';
require $dir.'Worksheet/ColumnIterator.php';
require $dir.'Worksheet/Drawing.php';
require $dir.'Worksheet/HeaderFooter.php';
require $dir.'Worksheet/HeaderFooterDrawing.php';
require $dir.'Worksheet/Iterator.php';
require $dir.'Worksheet/MemoryDrawing.php';
require $dir.'Worksheet/PageMargins.php';
require $dir.'Worksheet/PageSetup.php';
require $dir.'Worksheet/Protection.php';
require $dir.'Worksheet/Row.php';
require $dir.'Worksheet/RowCellIterator.php';
require $dir.'Worksheet/RowDimension.php';
require $dir.'Worksheet/RowIterator.php';
require $dir.'Worksheet/SheetView.php';
require $dir.'Worksheet/Worksheet.php';
require $dir.'Worksheet/AutoFilter/Column.php';
require $dir.'Worksheet/AutoFilter/Column/Rule.php';
require $dir.'Worksheet/Drawing/Shadow.php';

require $dir.'Writer/IWriter.php';
require $dir.'Writer/BaseWriter.php';
require $dir.'Writer/Csv.php';
require $dir.'Writer/Exception.php';
require $dir.'Writer/Html.php';
require $dir.'Writer/Ods.php';
require $dir.'Writer/Pdf.php';
require $dir.'Writer/Xls.php';
require $dir.'Writer/Xlsx.php';

require $dir.'Writer/Ods/WriterPart.php';
require $dir.'Writer/Ods/Content.php';
require $dir.'Writer/Ods/Formula.php';
require $dir.'Writer/Ods/Meta.php';
require $dir.'Writer/Ods/MetaInf.php';
require $dir.'Writer/Ods/Mimetype.php';
require $dir.'Writer/Ods/NamedExpressions.php';
require $dir.'Writer/Ods/Settings.php';
require $dir.'Writer/Ods/Styles.php';
require $dir.'Writer/Ods/Thumbnails.php';
require $dir.'Writer/Ods/Cell/Comment.php';

require $dir.'Writer/Pdf/Dompdf.php';
require $dir.'Writer/Pdf/Mpdf.php';
require $dir.'Writer/Pdf/Tcpdf.php';

require $dir.'Writer/Xls/BIFFwriter.php';
require $dir.'Writer/Xls/Escher.php';
require $dir.'Writer/Xls/Font.php';
require $dir.'Writer/Xls/Parser.php';
require $dir.'Writer/Xls/Workbook.php';
require $dir.'Writer/Xls/Worksheet.php';
require $dir.'Writer/Xls/Xf.php';

require $dir.'Writer/Xlsx/WriterPart.php';
require $dir.'Writer/Xlsx/Chart.php';
require $dir.'Writer/Xlsx/Comments.php';
require $dir.'Writer/Xlsx/ContentTypes.php';
require $dir.'Writer/Xlsx/DefinedNames.php';
require $dir.'Writer/Xlsx/DocProps.php';
require $dir.'Writer/Xlsx/Drawing.php';
require $dir.'Writer/Xlsx/Rels.php';
require $dir.'Writer/Xlsx/RelsRibbon.php';
require $dir.'Writer/Xlsx/RelsVBA.php';
require $dir.'Writer/Xlsx/StringTable.php';
require $dir.'Writer/Xlsx/Style.php';
require $dir.'Writer/Xlsx/Theme.php';
require $dir.'Writer/Xlsx/Workbook.php';
require $dir.'Writer/Xlsx/Worksheet.php';
require $dir.'Writer/Xlsx/Xlfn.php';

?>