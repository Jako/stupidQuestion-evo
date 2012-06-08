<?php
$settings['question'][1] = array('der Vorname von ', 'das erste Wort von ');
$settings['question'][2] = array('der Nachname von ', 'das letzte Wort von ');
$settings['question'] = array_merge($settings['question'][1], $settings['question'][2]);
$settings['intro'] = array('Wie lautet [+question+]?', 'Was ist [+question+]?', 'Fangfrage: [+question:ucfirst+] lautet:', 'Dumme Frage: [+question:ucfirst+] ist:');
$settings['answer'] = array('Karl Valentin', 'Peter Alexander', 'Elke Sommer', 'Anna Blume');
$settings['formFields'] = array('dumme-frage', 'bloede-frage', 'fangfrage', 'bottrap', 'nur-eine-frage');
$settings['required'] = '(benötigt)';
$settings['requiredMessage'] = 'Bitte die Frage beantworten';
?>

