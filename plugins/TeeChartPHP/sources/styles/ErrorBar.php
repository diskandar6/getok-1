<?php
/**
 *
 * <p>Title: ErrorBar class</p>
 *
 * <p>Description: ErrorBar Series.</p>
 *
 * <p>Example:
 * <pre><font face="Courier" size="4">
 * series = new ErrorBar(myChart.getChart());
 * series.setColor(Color.RED);
 * series.getGradient().setDirection(GradientDirection.VERTICAL);
 * series.getGradient().setUseMiddle(true);
 * series.getGradient().setMiddleColor(Color.YELLOW);
 * series.getGradient().setStartColor(Color.BLUE);
 * series.getErrorPen().setColor(Color.BLUE);
 * series.getErrorValues().setDateTime(false);
 * series.clear();
 * series.add(0,-123,23,"", Color.EMPTY);
 * series.add(1,432,65,"", Color.EMPTY);
 * series.add(2,-88,13,"", Color.EMPTY);
 * series.add(3,222,44,"", Color.EMPTY);
 * series.add(4,-321,49,"", Color.EMPTY);
 * </font></pre></p>
 *
 * <p>Copyright (c) 2005-2014 by Steema Software SL. All Rights
 * Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 */
 
class ErrorBar extends CustomError {

    private static $serialVersionUID = 1;

    function __construct($c=null) {
        parent::__construct($c);

        $this->bDrawBar = true;
        $this->iErrorStyle = ErrorStyle::$TOP;
    }

    public function prepareForGallery($isEnabled) {
        $this->getErrorPen()->setWidth(2);
        parent::prepareForGallery($isEnabled);
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return Language::getString("GalleryErrorBar");
    }
}
?>