stringReplace package
=================
## Description
This package contains one trait file that allows you to replace values in strings based on the provided data.
-------- 
### Examples:


```php
echo self::stringReplace('Hello, :name! There are :time left until the new year', [
    'name' => 'John',
    'time' => '11 days'
]);
// Hello, John! There are 11 days left until the new year
```
### 
But that's not very interesting, is it?)
Let's decline the days!
```php
$text = 'Hello, :name! There are :time :time[{1}day|days] left until the new year';
echo self::stringReplace($text, [
'name' => 'John',
'time' => 1
]);
// Hello, John! There are 1 day left until the new year
echo self::stringReplace($text, [
'name' => 'John',
'time' => 2
]);
// Hello, John! There are 2 days left until the new year
echo self::stringReplace($text, [
'name' => 'John',
'time' => 23
]);
// Hello, John! There are 23 days left until the new year
```

### 
If you decide to "program" the text...
```php
$text = 'You have :count :count[tries|try|tries] left!'
    .':count[{0} Want to buy more? for $:price?]';
echo StringReplace::replace($text, [
    'count' => 1,
    'price' => 9.99
]);
// You have 1 try left!
echo StringReplace::replace($text, [
    'count' => 0,
    'price' => 9.99
]);
// You have 0 tries left! Want to buy more? for $9.99?
$text = 'You have :count :count[tries|try|tries] left!'
    .':count[{0} Want to buy more? for $:price?| Keep playing!]';
echo StringReplace::replace($text, [
    'count' => 1,
    'price' => 9.99
]);
// You have 1 try left! Keep playing!
```

### 
If the variable is not passed, it will remain as is (almost):
```php
$text = 'Hello, :name! There are :time :time[{_1}day|days] left until the new year';
echo self::stringReplace($text, [
    'time' => 11
]);
// Hello, :name! There are 11 days left until the new year
echo self::stringReplace($text);
// Hello, :name! There are :time :time[...] left until the new year
```

###
###

---------------

---------------
## Описание
Этот пакет содержит один trait файл, который позволяет заменять значения в строки на основе переданных данных.

--------
### Примеры:
```php
echo self::stringReplace('Привет, :name! До нового года осталось: :time', [
    'name' => 'Иван'
    'time' =>  '11 дней'
]);
// Привет, Иван! До нового года осталось: 11 дней
```
###
Но так не особо интересно ведь?)
Давайте склонять дни!
```php
$text = 'Привет, :name! До нового года осталось: :time :time[{_1}день|{_2-_4}дня|{11}дней|дней]';
echo self::stringReplace($text, [
    'name' => 'Иван'
    'time' =>  11
]);
// Привет, Иван! До нового года осталось: 11 дней

echo self::stringReplace($text, [
    'name' => 'Иван'
    'time' =>  2
]);
// Привет, Иван! До нового года осталось: 2 дня

echo self::stringReplace($text, [
    'name' => 'Иван'
    'time' =>  23
]);
// Привет, Иван! До нового года осталось: 23 дня
```
###
Если вы решили "программировать" текст...
```php
$text = 'У вас осталось: :count :count[попыток|попытка|попыток]!'
    .':count[{0} Хотите приобрести еще? за $:price?]';
echo StringReplace::replace($text, [
    'count' =>  1,
    'price' => 9.99
]);
// У вас осталось: 1 попытка!

echo StringReplace::replace($text, [
    'count' =>  0,
    'price' => 9.99
]);
// У вас осталось: 0 попыток! Хотите приобрести еще? за $9.99?

$text = 'У вас осталось: :count :count[попыток|попытка|попыток]!'
    .':count[{0} Хотите приобрести еще? за $:price?| Играем дальше!]';
echo StringReplace::replace($text, [
    'count' =>  1,
    'price' => 9.99
]);
// У вас осталось: 1 попытка! Играем дальше!
```
###
В случае, если переменная не будет передана, останется как есть (почти):
```php
$text = 'Привет, :name! До нового года осталось: :time :time[{_1}день|{_2-_4}дня|{11}дней|дней]';
echo self::stringReplace($text, [
    'time' =>  11
]);
// Привет, :name! До нового года осталось: 11 дней

echo self::stringReplace($text);
// Привет, :name! До нового года осталось: :time :time[...]
```