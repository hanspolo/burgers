<?php

namespace datatype;

/**
 * 
 * @author Mohiddeen Mneimne <admin@mohiddeen-mneimne.com>
 * 
 */

Class DropDownList extends DataType {

    public function validate($value, $options = array()) {
        return $value == "" ? FALSE : TRUE;
    }

    /**
     *  @see \datatype\DateType::renderForm($name, $value)
     */
    public function renderForm($name, $value = null, $error = false, $options = array()) {
        $f3 = \Base::instance();

        $form = "<label>";
        $form .= $f3->exists("lng.$name") ? $f3->get("lng.$name") : $name;
        $form .= "</label>";
        $form .= "<select name=\"$name\"";
        if ($error)
            $form .= "class=\"error\" ";
        $form .= ">";

        if (array_key_exists("default", $options)) {
            $form .= "<option value=\"\"> please select </option>";
        }

        foreach ($options['values'] as $name => $item) {
            $form .= "<option value=\"$item\" ";
            if ($value == $item)
                $form .="selected";
            $form .=">$name</option>";
        }
        $form .= "</select>";

        return $form;
    }

}
