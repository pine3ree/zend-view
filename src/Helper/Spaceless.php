<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\View\Helper;

/**
 * Helper for rendering a portion of HTML content without space between
 * sibling elements' ending and opening tags
 */
class Spaceless extends AbstractHelper
{
    /**
     * Registry key for placeholder
     *
     * @var string
     */
    protected $regKey = 'Zend_View_Helper_Spaceless';

    /**
     * Is capture lock?
     *
     * @var bool
     */
    protected $captureLock;

    /**
     * Start content capture
     *
     * @return void
     */
    public function start()
    {
        if ($this->captureLock) {
            throw new Exception\RuntimeException('Cannot nest spaceless captures');
        }
        $this->captureLock = true;
        ob_start();
    }

    /**
     * End content capture, alter content and possibly echo it.
     *
     * @param bool $echo Echo captured content?
     * @return string
     */
    public function end($echo = true)
    {
        $content           = ob_get_clean();
        $this->captureLock = false;

        $content = preg_replace('/>\s+</', '><', $content);

        if ($echo) {
            echo $content;
        }

        return $content;
    }
}
