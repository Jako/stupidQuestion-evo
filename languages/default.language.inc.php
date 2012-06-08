<?php
$settings['question'][1] = array('the given name of ', 'the first word of ');
$settings['question'][2] = array('the family name von ', 'the last word of ');
$settings['question'] = array_merge($settings['question'][1], $settings['question'][2]);
$settings['intro'] = array('What is [+question+]?', 'What\'s [+question+]?', 'Trick question: [+question:ucfirst+] reads:', 'Stupid question: [+question:ucfirst+] is:');
$settings['answer'] = array('Karl Valentin', 'Peter Alexander', 'Elke Sommer', 'Anna Blume');
$settings['formFields'] = array('stupid-question', 'silly-question', 'trickquestion', 'bottrap', 'only-one-question', 'please-answer-this');
$settings['required'] = '(required)';
$settings['requiredMessage'] = 'Please answer the question';
?>

