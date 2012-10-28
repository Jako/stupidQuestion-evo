<?php
/*
 * @category 	classfile
 * @version 	0.6
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @author		Jako (thomas.jakobi@partout.info)
 *
 * @internal    description: <strong>0.5</strong> Captcha for MODX Evolution
 */

if (!class_exists('JavaScriptPacker')) {
	include DF_BASE_PATH . 'includes/class.JavaScriptPacker.php';
}
if (!class_exists('dfChunkie')) {
	include DF_BASE_PATH . 'includes/chunkie.class.inc.php';
}

class stupidQuestion {

	public $output = array();
	public $answer = array();
	private $settings = array();
	private $templates = array();
	private $language;

	function stupidQuestion($language, $formcode = '') {
		$this->language = $language;
		$this->setSettings();
		$this->setTemplates($formcode);
		$this->setQuestion();
	}

	// Return the include path of a configuration/template/whatever file
	function includeFile($name, $type = 'config', $extension = '.inc.php') {

		$folder = (substr($type, -1) != 'y') ? $type . 's/' : substr($folder, 0, -1) . 'ies/';
		$allowedConfigs = glob(DF_BASE_PATH . $folder . '*.' . $type . $extension);
		$configs = array();
		foreach ($allowedConfigs as $config) {
			$configs[] = preg_replace('=.*/' . $folder . '([^.]*).' . $type . $extension . '=', '$1', $config);
		}

		if (in_array($name, $configs)) {
			$output = DF_BASE_PATH . $folder . $name . '.' . $type . $extension;
		} else {
			if (file_exists(DF_BASE_PATH . $folder . 'default.' . $type . $extension)) {
				$output = DF_BASE_PATH . $folder . 'default.' . $type . $extension;
			} else {
				$output = 'Allowed ' . $name . ' and default stupidQuestion ' . $type . ' file "' . DF_BASE_PATH . $folder . 'default.' . $type . $extension . '" not found. Did you upload all files?';
			}
		}
		return $output;
	}

	function setSettings() {
		$settings = array();
		include ($this->includeFile($this->language, 'language'));
		$this->settings = $settings;
		return;
	}

	function setTemplates($formcode) {
		if ($formcode == '') {
			$this->templates['formcode'] = '@CODE:' . file_get_contents($this->includeFile('formcode', 'template', '.html'));
		} else {
			$this->templates['formcode'] = $formcode;
		}
		$this->templates['jscode'] = '@CODE:' . file_get_contents($this->includeFile('jscode', 'template', '.js'));
		$this->templates['jswrapper'] = '@CODE:' . file_get_contents($this->includeFile('jswrapper', 'template', '.js'));
		return;
	}

	function setQuestion() {
		// Random values
		$randQuestion = rand(0, count($this->settings['questions']) - 1);
		$randIntro = rand(0, count($this->settings['intro']) - 1);
		$randAnswer = rand(0, count($this->settings['answer']) - 1);
		$randFormField = rand(0, count($this->settings['formFields']) - 1);

		// get $_POST and replace values with session values
		if (isset($_SESSION['StupidQuestion'])) {
			foreach ($this->settings['formFields'] as $formKey => $formField) {
				if (in_array($formField, array_keys($_POST))) {
					$randQuestion = $_SESSION['StupidQuestion'];
					$randAnswer = $_SESSION['StupidQuestionAnswer'];
					$randFormField = $formKey;
				}
			}
		}
		$_SESSION['StupidQuestion'] = $randQuestion;
		$_SESSION['StupidQuestionFormField'] = $randFormField;
		$_SESSION['StupidQuestionAnswer'] = $randAnswer;

		// form fields
		$answer = explode(' ', $this->settings['answer'][$randAnswer]);
		$value = ($randQuestion < count($this->settings['questions_first'])) ? $answer[0] : $answer[1];
		$othervalue = ($randQuestion < count($this->settings['questions_first'])) ? $answer[1] : $answer[0];
		$frage = $this->settings['questions'][$randQuestion];
		$formField = $this->settings['formFields'][$randFormField];

		// parse stupid question template and javscript template
		$parser = new dfChunkie($this->templates['jscode']);
		$parser->AddVar('id', $formField);
		$parser->AddVar('othervalue', $othervalue);
		$parser->AddVar('value', $value);
		$jsCode = $parser->Render();

		$parser = new dfChunkie('@CODE:' . $this->settings['intro'][$randIntro]);
		$parser->AddVar('question', $frage . $this->settings['answer'][$randAnswer]);
		$question = $parser->Render();

		$parser = new dfChunkie($this->templates['formcode']);
		$parser->AddVar('id', $formField);
		$parser->AddVar('value', $value);
		$parser->AddVar('question', $question);
		$parser->AddVar('required', $this->settings['required']);
		$parser->AddVar('requiredMessage', $this->settings['requiredMessage']);
		$this->output['htmlCode'] = $parser->Render();

		$this->answer['answer'] = $value;
		$this->answer['formfield'] = $formField;

		$packer = new JavaScriptPacker($jsCode, 'Normal', true, false);
		$parser = new dfChunkie($this->templates['jswrapper']);
		$parser->AddVar('packed', $packer->pack());
		$this->output['jsCode'] = $parser->Render();
		return;
	}

	function cleanUp() {
		unset($_SESSION['StupidQuestion']);
		unset($_SESSION['StupidQuestionFormField']);
		unset($_SESSION['StupidQuestionAnswer']);
	}

}

?>
