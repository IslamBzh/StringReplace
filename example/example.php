<?php

require '..\vendor\autoload.php';

use IslamBzh\stringReplace\StringReplace;

$text = 'Привет, :name! До нового года осталось: :days :days[{_1}день|{_2-_4}дня|{11}дней|дней]';

echo "\\\\ ";

echo StringReplace::replace('У вас осталось :count :count[попыток|попытка|попыток]!:count[{0} Хотите приобрести еще?]', [
    'count' =>  10
]);
echo "\n\n\\\\ ";

echo StringReplace::replace('У вас осталось :count :count[попыток|попытка|попыток]!:count[{0} Хотите приобрести еще? за $:price]', [
    'count' =>  0,
    'price' => 9.99
]);
echo "\n\n\\\\ ";

echo StringReplace::replace($text, [
    'days' =>  23
]);
echo "\n\n\\\\ ";

echo StringReplace::replace('У вас осталось :count :count[{0,2-*}попыток|{1}попытка] до :time', [
    'count' =>  11,
    'time' => '12:00'
]);
echo "\n\n\\\\ ";

echo StringReplace::replace('У вас осталось :count :count[{0,2-*}попыток|{1}попытка] до :time', [
    'count' =>  1,
    'time' => '12:00'
]);