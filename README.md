stupidQuestion
================================================================================

Userfriendly Captcha for MODX Evolution

Features:
--------------------------------------------------------------------------------
With this eForm event functions a stupid question captcha is inserted placeholder `[+stupidquestion+]` in the form template. The form field is filled and hidden by a javascript that is packed by a javascript packer. The packer scrambles the code and because of the input name contains different counts of hyphens the right answer is does placed at the same position. The filling bots have to execute javascript - a lot don't do that.

Installation:
--------------------------------------------------------------------------------
1. Upload all files into the new folder *assets/snippets/stupidQuestion*
2. Create a new snippet called StupidQuestion with the following snippet code
    `<?php
    include (MODX_BASE_PATH . 'assets/snippets/stupidquestion/stupidQuestion.snippet.php');
    ?>`
3. Create a new snippet called StupidQuestionJot with the following snippet code
    `<?php
    include (MODX_BASE_PATH . 'assets/snippets/stupidquestion/stupidQuestionJot.snippet.php');
    ?>`

eForm Usage
--------------------------------------------------------------------------------

The snippet has to be invoked before the eForm call(s) it should work on. If no other eform events should be called, the snippet could be called by eForm parameter eForm runSnippet. Otherwise the original event functions could be called in stupidQuestion snippet.

``[!StupidQuestion? &eFormOnBeforeFormParse=`…` &eFormOnMailSent=`…` &language=`…` &template=`…`!]``
``[!eForm? &eFormOnBeforeFormParse=`stupidQuestionBeforeFormParse` &eFormOnMailSent=`stupidQuestionMailSent` ... !]``

Property | Description | Default
---- | ----------- | -------
eFormOnBeforeFormParse | event funktion for eForm (will be called after the stupidQuestion event functions) | -
eFormOnMailSent | event funktion for eForm (will be called after the stupidQuestion event functions) | -
language | which language file is used | english
template | template chunk for the stupid question form field | `formcode.template.html` in folder `templates`

Jot Usage
--------------------------------------------------------------------------------

The stupid question captcha could be used in Jot, too. Insert the following call inside of the Jot form template chunk
``[!StupidQuestion? &language=`…` &template=`…`!]``

After that the following lines have to be patched into jot.class.inc.php

Replace line 540:
```php
if ($saveComment && !(($this->config["captcha"] == 0 || $this->config["captcha"] == 3 || isset($_POST['vericode']) && isset($_SESSION['veriword']) && $_SESSION['veriword'] == $_POST['vericode']))) {
```


Add Before line 548:
```php
// -- stupidQuestion enhancement
if ($saveComment && $this->config["captcha"] == 3) {
	if (!class_exists('stupidQuestion')) {
		define(DF_PATH, 'assets/snippets/stupidquestion/');
		define(DF_BASE_PATH, MODX_BASE_PATH . DF_PATH);
		include ('assets/snippets/stupidquestion/stupidQuestion.class.php');
	}
	$stupidQuestion = new stupidQuestion('german');
	if (isset($_POST[$stupidQuestion->answer['formfield']]) && $_POST[$stupidQuestion->answer['formfield']] == $stupidQuestion->answer['answer']) {
		$stupidQuestion->cleanUp();
	} else {
		$this->form['error'] = 2; // Veriword / Captcha incorrect
		$stupidQuestion->cleanUp();
		return;
	}
}
// -- stupidQuestion
```

After that Jot should be called with the parameter ``&captcha=`3```

Property | Description | Default
---- | ----------- | -------
language | which language file is used | english
template | template chunk for the stupid question form field | `formcode.template.html` in folder `templates`

Notes:
--------------------------------------------------------------------------------
1. Uses: PHP packer implementation on http://joliclic.free.fr/php/javascript-packer/en/
2. Bases on a captcha idea of Peter Kröner: http://www.peterkroener.de/dumme-frage-captchas-automatisch-ausfuellen/

