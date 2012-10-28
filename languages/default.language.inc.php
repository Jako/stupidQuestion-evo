<?php
$settings['questions_first'] = array('the given name of ', 'the first word of ');
$settings['questions_second'] = array('the family name von ', 'the last word of ');
$settings['questions'] = array_merge($settings['questions_first'], $settings['questions_second']);
$settings['intro'] = array('What is [+question+]?', 'What\'s [+question+]?', 'Trick question: [+question:ucfirst+] reads:', 'Stupid question: [+question:ucfirst+] is:');
$settings['answer'] = array('Karl Valentin', 'Peter Alexander', 'Elke Sommer', 'Anna Blume');
$settings['formFields'] = array('stupid-question', 'silly-question', 'trickquestion', 'bottrap', 'only-one-question', 'please-answer-this');
$settings['required'] = '(required)';
$settings['requiredMessage'] = 'Please answer the question';
?>

