<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 7/7/14
 * Time: 7:37 PM
 */

namespace Yoda\EventBundle\Twig;


use Yoda\EventBundle\Util\DateUtil;

class EventExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('ago', array($this, 'ago')));
    }

    public function ago(\DateTime $dt)
    {
        return DateUtil::ago($dt);
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'event';
    }

} 