<?php
/**
 * File Name: Form.php
 * @author Ondřej Koubek
 * Date: 26.01.2022
 * Time: 14:16
 */

namespace koubeko\phpmvc\form;

use koubeko\phpmvc\Model;
use JetBrains\PhpStorm\Pure;

/**
 * Class Form
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\form
 */
class Form
{
    public static function begin(string $action, string $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    #[Pure] public function field(Model $model, string $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}