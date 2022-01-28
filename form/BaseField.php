<?php
/**
 * File Name: BaseField.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 12:41
 */

namespace koubeko\phpmvc\form;

use koubeko\phpmvc\Model;

/**
 * Class BaseField
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\form
 */
abstract class BaseField
{
    public Model $model;
    public string $attribute;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString(): string
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ', $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}