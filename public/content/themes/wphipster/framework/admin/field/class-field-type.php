<?php
/**
 * Created by PhpStorm.
 * User: dejano
 * Date: 11/12/15
 * Time: 4:59 AM
 */

namespace wp_hipster\admin;



abstract class Field_Type
{
    const TEXT = 0;
    const SELECT = 1;
    const RADIO = 2;
    const CHECKBOX = 3;
    const TEXT_AREA = 4;
}