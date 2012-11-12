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
$GLOBALS['df_eFormOnBeforeFormParse'] = isset($eFormOnBeforeFormParse) ? $eFormOnBeforeFormParse : '';
$GLOBALS['df_eFormOnMailSent'] = isset($eFormOnMailSent) ? $eFormOnMailSent : '';
$GLOBALS['df_language'] = isset($language) ? $language : 'english';
$GLOBALS['df_template'] = isset($template) ? $template : '';
if (!function_exists('stupidQuestionBeforeFormParse')) {

	function stupidQuestionBeforeFormParse(&$fields, &$templates) {
		$stupidQuestion = new stupidQuestion($GLOBALS['df_language'], $GLOBALS['df_template']);
		$templates['tpl'] = str_replace('[+stupidquestion+]', $stupidQuestion->output['htmlCode'], $templates['tpl']);
		$templates['tpl'] .= $stupidQuestion->output['jsCode'];
		if ($GLOBALS['df_eFormOnBeforeFormParse'] && function_exists($GLOBALS['df_eFormOnBeforeFormParse'])) {
			return $GLOBALS['df_eFormOnBeforeFormParse']($fields, $templates);
		}
		return true;
	}

	function stupidQuestionMailSent(&$fields) {
		$stupidQuestion = new stupidQuestion($GLOBALS['df_language']);
		$stupidQuestion->cleanUp();
		if ($GLOBALS['df_eFormOnMailSent'] && function_exists($GLOBALS['df_eFormOnMailSent'])) {
			return $GLOBALS['df_eFormOnMailSent']($fields);
		}
		return true;
	}

}

return '';
?>
