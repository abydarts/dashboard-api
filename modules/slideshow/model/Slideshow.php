<?php
/**
 * Slideshow
 * @package slideshow
 * @version 0.0.1
 */

namespace Slideshow\Model;

class Slideshow extends \Mim\Model
{

    protected static $table = 'slideshow';

    protected static $chains = [];

    protected static $q = ['name'];
}