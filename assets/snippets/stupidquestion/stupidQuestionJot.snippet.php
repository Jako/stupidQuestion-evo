<?php
/*
 * @category 	snippet
 * @version 	0.6.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @author		Jako (thomas.jakobi@partout.info)
 *
 * @internal    description: <strong>0.6.3</strong> Stupid Question Captcha for MODX Evolution
 */
// set customtv (base) path
define('DF_PATH', str_replace(MODX_BASE_PATH, '', str_replace('\\', '/', realpath(dirname(__FILE__)))) . '/');
define('DF_BASE_PATH', MODX_BASE_PATH . DF_PATH);

if (!class_exists('stupidQuestion')) {
	include DF_BASE_PATH . 'stupidQuestion.class.php';
}

// Parameter
$language = isset($language) ? $language : 'english';
$template = isset($template) ? $template : '';

// Snippet logic
$stupidQuestion = new stupidQuestion($language, $template);
$templates['tpl'] = str_replace('[+stupidquestion+]', $stupidQuestion->output['htmlCode'], $templates['tpl']);
$output = preg_replace('!eform=\"[^\"]+"\s*!', '', $stupidQuestion->output['htmlCode']);
$output .= "\r\n" . $stupidQuestion->output['jsCode'];
return $output;
?>
