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

Usage
--------------------------------------------------------------------------------

The snippet has to be invoked before the eForm call(s) it should work on. If no other eform events should be called, the snippet could be called by eForm parameter eForm runSnippet. Otherwise the original event functions could be called in stupidQuestion snippet.

``[!StupidQuestion? &eFormOnBeforeFormParse=`…` &eFormOnMailSent=`…` &language=`english`!]
[!eForm? &eFormOnBeforeFormParse=`stupidQuestionBeforeFormParse` &eFormOnMailSent=`stupidQuestionMailSent` ... !]``

Property | Description | Default
---- | ----------- | -------
eFormOnBeforeFormParse | event funktion for eForm (will be called after the stupidQuestion event functions) | -
eFormOnMailSent | event funktion for eForm (will be called after the stupidQuestion event functions) | -
language | which language file is used | english

Notes:
--------------------------------------------------------------------------------
1. Uses: PHP packer implementation on http://joliclic.free.fr/php/javascript-packer/en/
2. Bases on a captcha idea of Peter Kröner: http://www.peterkroener.de/dumme-frage-captchas-automatisch-ausfuellen/

