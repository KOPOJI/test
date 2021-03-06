##Правила интеграции верстки на битрикс
* Данные шаблонов, своих компонентов и т.п. должны быть размещены в директории /local (если ее не существует - необходимо создать вручную). Редактировать код шаблона или компонента, размещенные в системной директории (например, /bitrix/components) запрещено.
* Для избежания путаницы дублей шаблонов и т.п. быть не должно. Т.е., если есть директория /local/templates/.default, то директории /bitrix/templates/.default быть не должно
* Код должен быть корректно оттабулирован и отформатирован. [Такое](http://joxi.ru/L21leDaC6Dobbm) оформление кода недопустимо, [такое](http://joxi.ru/V2VpkzXH0Gn7Dr) - приветствуется. В случае, если строка длинная, и нежелательно разбивать по тегу (например, значение внутри тега используется в JS), можно использовать [такой](http://joxi.ru/a2XDy5kHypOX32) синтаксис
* Скрипты и стили должны быть по максимуму вынесены в соответствующие файлы скриптов или стилей. В обратном случае поиск стиля или скрипта может затянуться на неопределенный период. Пример: `<a href="#" onclick="$('#boxgo').arcticmodal(); return false;"...>...</a>` - onclick должен быть вынесен в скрипты
* Скрипты и стили должны подключаться в header.php, с использованием API битрикса. Исключение составляют подключаемые по условию (IF IE, etc..) стили/скрипты, а также стили с импортами, если они не могут быть подключены самыми первыми (иначе будет ошибка, т.к. директива @import должна быть в самом начале файла - а в идеале скрипты и стили должны сжиматься в один-два файла).
* Скрипты и стили должны подключаться в следующем порядке - сначала системные и библиотеки, зачем свои собственные. Не наоборот и не в перемешку.
* Никаких тегов `<style>...</style>` внутри body быть не должно - это невалидно.
* Тег `<h1>` должен быть только один на страницу. Тоже самое относится к id элементов - id должен быть уникальным в рамках одной страницы, дублирование id невалидно, а также создаст проблемы в JS
* Подключаемые скрипты и стили не должны дублироваться, по возможности необходимо использовать не более чем по одному плагину на действие (например, использования несколько различных плагинов для модалок одновременно лучше избегать - живой пример: fancybox+articmodal+magnificPopup - в идеале должен использоваться один плагин)
* Все включаемые файлы должны располагаться в директории include. Внутри возможно разделение по частям/страницам (header, footer, index/main, catalog, etc..)
* Файлы шаблона (header, footer, etc..), а также файлы шаблонов компонентов должны проверять пролог вначале файла
* Директория (ID) шаблона, а также его описание в админке должно быть осмысленным и отражать реальное назначение шаблона. Шаблон с ID "empty" - пример неверного названия шаблона. "main", "index", "catalog" - пример верного ID
* Все разделы должны быть названы соответствующе. Не допускается непонятных сокращений разделов, наподобие "dop" для раздела "Дополнительное оборудование", или "part" для раздела "Партнерам". ЧПУ должно быть человекопонятным URL, а не станком ЧПУ.
* Запрещено дублирование контента в разделах и подразделах. Пример - /about/index.php равен /about/about/index.php. Вообще разделов в духе "/about/about" или "/contact/contact" быть не должно
* Название файлов также должно быть понятным и отражать суть кода внутри - программист должен представлять, за что отвечает код, который находится внутри определенного файла, без открывания данного файла. Поэтому размещение внутри файла с названием, например, check.php, кода отправки сообщения является неверным. Название файла должно отражать либо действия внутри файла, либо страницу/часть кода, откуда приходит запрос на этот файл/куда подключается этот файл. Например, feedback.php - файл обработчика формы обратной связи, review.php - файл обработчика отзывов. Название bron1valid является плохим наименованием и на взгляд со стороны отдает г..кодом только исходя из самого этого названия :)
* Не допускается именования полей, файлов, директорий и т.п. в различных стилях, смешивание транслита и слов на английском языке. Например, если поле имени в форме называется "name", то поле с фамилией должно называться "surname", а не "familiya". 
* В название разделов, файлов и т.п., в начале и конце имени не должно быть лишних символов - должны быть буквы/цифры. Пример неверного названия раздела - "lobbi-bar-oniks-", должно быть "lobbi-bar-oniks". Тоже самое относится и к символьным кодам элементов, и к названиям файлов.
* В header.php и footer.php в идеале должен быть только код, который используется на всех страницах. Если изменения слишком различны на разных страницах - то имеет смысл создать несколько различных шаблонах и использовать соответствующий, битрикс позволяет указать различные условия подключения того или иного шаблона. Никаких ветвлений в виде `if($dir == '/contact')..` быть либо не должно, либо самый минимум (но крайне не рекомендуется)
* Все фразы по возможности должны быть вынесены в языковые файлы либо включаемые области (в зависимости от используемого контекста).
* В коде шаблонов по возможности должно быть как можно меньше различных ветвлений условий (в идеале - вообще без них, или максимум - проверка, в корне сайта или нет)
* Адреса ссылок на стили, скрипты, включаемые области и т.п. в шаблонах должны начинаться либо с вывода константы SITE_TEMPLATE_PATH, либо с вывода константы SITE_DIR. Если стили и скрипты находятся в корне сайта (например, в директории /assets), то путь должен начинаться со слэша. Примеры путей ссылок: [неверно](http://joxi.ru/GrqK60wUNbWNW2), [верно](http://joxi.ru/n2YB761Uj08ooA)
* Необходимо избегать использования множественных вызовов `$(document).ready(function(){...})` или `$(function(){...})` - все должно быть внутри одной такой "проверки". Пример:
```javascript
$(function() {
    $('foo').bar();
    //..
})
$(function() {
    $('bar').foo();
    //...
})
```
Должно быть так:
```javascript
$(function() {
    $('foo').bar();
    //...
    $('bar').foo();
    //...
})
```
* Обработчики событий (форм, запросов и т.п.) должны располагаться внутри директории /ajax/
* Верстка, отличающаяся по разделам, должна находится в файле index.php соответствующего раздела, а не в хедере с условием на тридцать строк
* Код обработчиков событий форм должен проверять наличие отправленных данных
* По возможности в CSS пути к картинкам должны указываться относительные, а не абсолютные. Пример (при использовании css из директории шаблона):
```css
/*Неверный код*/
.eat{
    background-image: url('/local/templates/main/images/section/image_35.jpg');
}
/*Верный код*/
.eat{
    background-image: url('../images/section/image_35.jpg');
}
``` 
* Разбивать валидацию полей и обработку самого события в случае успешной валидации не следует - всю логику необходимо размещать в одном файле
* Правильно интегрированная верстка в битрикс должна давать возможность контент-менеджеру править как можно больше элементов на странице в режиме правки через визуальный редактор, а именно:
1. Все тексты и т.п. должны быть вынесены во включаемые области
2. Верстка и программный код во включаемых областях должны быть по-минимуму, во избежания некорректного закрытия тегов или ошибки после сохранения из режима визуального редактирования
3. Менюшки должны быть компонентами
4. В шаблонах компонентов должны быть вызов подстановки id для появления всплывашек редактирования($this->GetEditAreaId)
5. Программной логики в шаблонах быть не должно, максимум - ветвления а-ля проверка наличия значения и циклы
6. Вся программная логика должна быть вынесена в result_modifier.php либо component_epilog.php (в зависимости от требуемых условий)
7. Скрипты и стили должны быть вынесены либо в общие файлы, либо в файлы script.js/style.css шаблона соответственно. Например, [такой](http://joxi.ru/KAg091zCgOBnkr) код должен быть в отдельном скрипте, а не в шаблоне
* Все тестовые страницы, файлы, разделы, демоданные в инфоблоках, тестовые учетные записи и т.п. должны быть удалены по окончанию разработки - http://joxi.ru/V2VpkzXH08M1Qr
* Заголовки страницы должны подставляться через вызов $APPLICATION->ShowTitle. В идеале вывод заголовка, хлебных крошек и т.п. должен быть в header.php
* В шаблонах компонента должно проверяться наличие контента, если контента нет - возвращать void (`return ;`) либо пустую строку/null (`return null;`), пример:
```php
if(empty($arResult['ITEMS']))
    return ;
```
* Верстка внутри шаблона компонента должна быть корректно закрыта - например, если есть открывающий тег `<div>`, то здесь же, в шаблоне, должен быть и закрывающий его `</div>`
* Компоненты должны корректно работать с автокешированием. Поэтому размещать компонент внутри другого компонента не рекомендуется. Например: есть задача, вывести список разделов и список элементов каждого раздела. Одно из решений - в цикле компонента bitrix:catalog.section.list вызывать компонент bitrix:catalog.section. Это будет плохим решением, т.к. кеширование может привести к неожиданному результату. Данную задачу необходимо решать через API битрикса, код необходимо писать в result_modifier.php - тогда не будет проблем.
* В случае, если верстка практически одинаковая, но отличаются данные (например, два блока - только один с заголовком "Услуги", а второй - "Партнеры", вся остальная верстка одинаковая), то следует использовать один и тот же шаблон, но с передачей дополнительного заголовка для компонента (он будет доступен, например, в `$arParams['TITLE']`).
* В результате натяжки верстки в консоли не должно быть никаких ошибок - ни ошибок скриптов, ни ошибок 404 и т.п.
* Сайт должен корректно отображаться что для администраторов сайта, что для гостей - т.е. должны быть верно настроены права доступа и т.п.
* Компоненты крайне нежелательно запихивать во включаемые области
* Все инструкции PHP должны ВСЕГДА заканчиваться точкой с запятой, независимо от наличия или отсутствия закрывающего тега PHP после инструкции.
* Файлы init.php и другие системные (dbconn.php, after_connect.php и т.п.) не должны содержать вывода пробелов или других символов. Пример, файл init.php:
```php
<?php
//some code...
?> <?php
//some else code...
```
Данный код может привести к ошибке при попытке отправить заголовки (например, может "сломать" авторизацию). Поэтому данный код должен выглядеть так:
```php
<?php
//some code...
?><?php
//some else code...
```
Либо, что еще лучше, так:
```php
<?php
//some code...

//some else code...
```
