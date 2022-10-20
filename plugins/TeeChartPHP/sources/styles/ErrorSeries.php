<?php
/**
 *
 * <p>Title: ErrorSeries class</p>
 *
 * <p>Description: ErrorSeries Series.</p>
 *
 * <p>Copyright (c) 2005-2018 by Steema Software SL. All Rights
 * Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 */

 class ErrorSeries extends CustomError {

    private static $serialVersionUID = 1;

    public function __construct($c=null) {
        parent::__construct($c);
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return Language::getString("GalleryError");
    }
}
?>