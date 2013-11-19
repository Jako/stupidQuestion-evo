<?php
/*
 * @category 	snippet
 * @version 	0.6.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @author		Jako (thomas.jakobi@partout.info)
 *
 * @internal    description: <strong>0.6.1</strong> Stupid Question Captcha for MODX Evolution
 */

// set base path
define('DF_PATH', str_replace(MODX_BASE_PATH, '', str_replace('\\', '/', realpath(dirname(__FILE__)))) . '/');
define('DF_BASE_PATH', MODX_BASE_PATH . DF_PATH);

if (!class_exists('stupidQuestion')) {
	include DF_BASE_PATH . 'stupidQuestion.class.php';
}

// Parameter
$language = isset($language) ? $language : 'english';
$template = isset($template) ? $template : '';

// Init class
if (!isset($modx->stupidQuestion)) {
	$modx->stupidQuestion = new stupidQuestion($language, $template);
}

$eFormOnBeforeFormParse = isset($eFormOnBeforeFormParse) ? $eFormOnBeforeFormParse : '';
$eFormOnMailSent = isset($eFormOnMailSent) ? $eFormOnMailSent : '';

if (!function_exists('stupidQuestionBeforeFormParse')) {

	function stupidQuestionBeforeFormParse(&$fields, &$templates) {
		global $modx;

		$templates['tpl'] = str_replace('[+stupidquestion+]', $modx->stupidQuestion->output['htmlCode'], $templates['tpl']);
		$templates['tpl'] .= $modx->stupidQuestion->output['jsCode'];
		if ($eFormOnBeforeFormParse && function_exists($eFormOnBeforeFormParse)) {
			return $eFormOnBeforeFormParse($fields, $templates);
		}
		return true;
	}

	function stupidQuestionMailSent(&$fields) {
		global $modx;

		$modx->stupidQuestion->cleanUp();
		if ($eFormOnMailSent && function_exists($eFormOnMailSent)) {
			return $eFormOnMailSent($fields);
		}
		return true;
	}

}

return '';
?>
