<?php
/*
 * @category 	snippet
 * @version 	0.6
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @author		Jako (thomas.jakobi@partout.info)
 *
 * @internal    description: <strong>0.6</strong> Stupid Question Captcha for MODX Evolution
 */

// set base path
define(DF_PATH, 'assets/snippets/stupidquestion/');
define(DF_BASE_PATH, MODX_BASE_PATH . DF_PATH);

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

$modx->stupidQuestion->eFormOnBeforeFormParse = isset($eFormOnBeforeFormParse) ? $eFormOnBeforeFormParse : '';
$modx->stupidQuestion->eFormOnMailSent = isset($eFormOnMailSent) ? $eFormOnMailSent : '';

if (!function_exists('stupidQuestionBeforeFormParse')) {

	function stupidQuestionBeforeFormParse(&$fields, &$templates) {
		global $modx;

		$templates['tpl'] = str_replace('[+stupidquestion+]', $modx->stupidQuestion->output['htmlCode'], $templates['tpl']);
		$templates['tpl'] .= $modx->stupidQuestion->output['jsCode'];
		if ($modx->stupidQuestion->eFormOnBeforeFormParse && function_exists($modx->stupidQuestion->eFormOnBeforeFormParse)) {
			return $modx->stupidQuestion->eFormOnBeforeFormParse($fields, $templates);
		}
		return true;
	}

	function stupidQuestionMailSent(&$fields) {
		global $modx;

		$modx->stupidQuestion->cleanUp();
		if ($modx->stupidQuestion->eFormOnMailSent && function_exists($modx->stupidQuestion->eFormOnMailSent)) {
			return $modx->stupidQuestion->eFormOnMailSent($fields);
		}
		return true;
	}

}

return '';
?>
