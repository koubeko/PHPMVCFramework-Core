<?php
/**
 * File Name: TextareaField.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 12:54
 */

namespace app\core\form;

/**
 * Class TextareaField
 *
 * @author Ondřej Koubek
 * @namespace app\core\form
 */
class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute},
        );
    }
}