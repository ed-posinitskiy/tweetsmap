<?php
/**
 * File contains class SearchForm
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\Form;

use Zend\Form\Form;

/**
 * Class SearchForm
 *
 * @package Application\Form
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
class SearchForm extends Form
{
    const EL_QUERY  = 'q';
    const EL_SUBMIT = 'submit_btn';


    /**
     * Form initialization
     */
    public function init()
    {
        $this->setAttribute('id', 'search_form');

        $this->add(
            [
                'name'       => static::EL_QUERY,
                'type'       => 'Text',
                'attributes' => [
                    'class'       => 'form-control',
                    'placeholder' => 'City name',
                    'id'          => 'search_query'
                ]
            ]
        );

        $this->add(
            [
                'name'       => static::EL_SUBMIT,
                'type'       => 'Button',
                'options'    => [
                    'label'  => 'Search',
                    'ignore' => true
                ],
                'attributes' => [
                    'class' => 'btn btn-primary btn-block',
                    'type'  => 'submit',
                ]
            ]
        );
    }

}