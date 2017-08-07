<?php
/**
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.registerAsset.php
 * Type:     function
 * Name:     registerAsset
 * Purpose:  assign js and css bundle to template
 * -------------------------------------------------------------
 *
 * Uses: {register_asset class='<class_name>'}
 *
 * @param array $params
 * @param Smarty_Internal_Template $template
 */
function smarty_function_registerAsset($params, Smarty_Internal_Template $template)
{
    if (!isset($params['class'])) {
        trigger_error("path: missing 'class' parameter");
    }

    $params['class']::register($template->tpl_vars['this']->value);
}
?>