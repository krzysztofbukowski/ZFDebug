<?php

/**
 * ZFDebug Zend Additions
 *
 * @category   ZFDebug
 * @package    ZFDebug_Controller
 * @subpackage Plugins
 */
class ZFDebug_Controller_Plugin_Debug_Plugin_Git
    extends ZFDebug_Controller_Plugin_Debug_Plugin
    implements ZFDebug_Controller_Plugin_Debug_Plugin_Interface
{

    /**
     * Contains plugin identifier name
     *
     * @var string
     */
    protected $_identifier = 'git';

    /**
     * Name of branch which the project is switched to
     *
     * @var string
     */
    protected $_branchName;

    /**
     * Base path of this application
     * String is used to strip it from filenames
     *
     * @var string
     */
    protected $_basePath;

    /**
     * Setting Options
     *
     * basePath:
     * This will normally not your document root of your webserver, its your
     * project root directory with /application, /library and /public
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        isset($options['base_path']) || $options['base_path'] = $_SERVER['DOCUMENT_ROOT'];
        $this->_basePath = realpath($options['base_path']);
    }

    /**
     * Gets identifier for this plugin
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Returns the base64 encoded icon
     *
     * @return string
     * */
    public function getIconData()
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAADPSURBVCjPdZFNCsIwEEZHPYdSz1DaHsMzuPM6RRcewSO4caPQ3sBDKCK02p+08DmZtGkKlQ+GhHm8MBmiFQUU2ng0B7khClTdQqdBiX1Ma1qMgbDlxh0XnJHiit2JNq5HgAo3KEx7BFAM/PMI0CDB2KNvh1gjHZBi8OR448GnAkeNDEDvKZDh2Xl4cBcwtcKXkZdYLJBYwCCFPDRpMEjNyKcDPC4RbXuPiWKkNABPOuNhItegz0pGFkD+y3p0s48DDB43dU7+eLWes3gdn5Y/LD9Y6skuWXcAAAAASUVORK5CYII=';
    }

    /**
     * Gets menu tab for the Debugbar
     *
     * @return string
     */
    public function getTab()
    {
        $this->_branchName = $this->_getBranchName();
        if ($this->_branchName == '') {
            return 'Git';
        }
        return "Git ({$this->_branchName})";
    }

    /**
     * Gets content panel for the Debugbar
     *
     * @return string
     */
    public function getPanel()
    {
        //return a space to prevent from displaying the default content
        return ' ';
    }

    //----------------- helper methods --------------------
    protected function _getBranchName()
    {
        return trim(`git rev-parse --abbrev-ref HEAD`);
    }
}