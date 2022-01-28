<?php
/**
 * File Name: TextareaField.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 12:54
 */

namespace koubeko\phpmvc\form;

/**
 * Class TextareaField
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\form
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