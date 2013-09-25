<?php

/**
 * ZFDebug Zend Additions
 *
 * @category   ZFDebug
 * @package    Tid_ZFDebug_Controller
 * @subpackage Plugins
 * @version    $Id: $
 */
class ZFDebug_Controller_Plugin_Debug_Plugin {

    const COLOR_RED = '#cc0000';
    const COLOR_PINK = '#F55874';
    const COLOR_GREEN = '#4e9a06';
    const COLOR_BLUE = '#4C97B4';
    const COLOR_VIOLET = '#75507b';

    protected $_closingBracket = null;

    public function getLinebreak() {
        return '<br' . $this->getClosingBracket();
    }

    public function getClosingBracket() {
        if (!$this->_closingBracket) {
            if ($this->_isXhtml()) {
                $this->_closingBracket = ' />';
            } else {
                $this->_closingBracket = '>';
            }
        }

        return $this->_closingBracket;
    }

    protected function _isXhtml() {
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $doctype = $view->doctype();
        return $doctype->isXhtml();
    }

    protected function _cleanData($values) {

        $linebreak = $this->getLinebreak();

        if (is_array($values)) {
            ksort($values);
        }
        $retVal = '<div class="pre">';
        foreach ($values as $key => $value) {
            $key = htmlspecialchars($key);
            if (is_string($value)) {
                $retVal .= $key . ' => ' . $this->_format('string', htmlspecialchars($value), self::COLOR_RED) . $linebreak;
            } else if (is_numeric($value)) {
                $retVal .= $key . ' => ' . $this->_format('number', $value, self::COLOR_GREEN) . $linebreak;
            } else if (is_array($value)) {
                $retVal .= $key . ' => ' . self::_cleanData($value);
            } else if (is_object($value)) {
                $retVal .= $key . ' => ' . $this->_format('object', get_class($value), self::COLOR_PINK) . $linebreak;
            } else if (is_null($value)) {
                $retVal .= $key . ' => ' . $this->_format(null, 'null', self::COLOR_BLUE) . $linebreak;
            } else if (is_bool($value)) {
                $retVal .= $key . ' => ' . $this->_format('boolean', $value ? 'true' : 'false', self::COLOR_VIOLET) . $linebreak;
            }
        }
        return $retVal . '</div>';
    }

    protected function _format($type, $value, $color) {
        return '<small>' . $type . '</small> <span style="color:' . $color . '">' . $value . '</span>';
    }

}
