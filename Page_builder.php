<?php
$filesJson = json_decode(file_get_contents('Pages.config.json', true), true);

$folder = 'Pages';

function create_file($folder)
{
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        echo "Папка успешно создана.\n";
    } else {
        echo "Папка уже существует.\n";
    }
}

create_file($folder);

$controllerContent = file_get_contents("routers/controllers.php");
function malware($controller, $vars){
    $output = $vars;
    if(isset($vars) && empty($vars)) {
        $output = '123'; // если переменная пуста, присваиваем значение '123'
    }
   
    if($controller == "PrivateController"){
        $func_malware = "'вы кто такие ? Я вас не звал идите нахуй !';";
    }
    if($controller == "PublicController"){
        $func_malware = "'лаадно, тебе все можно';";
    }
    return $func_malware;
}

foreach ($filesJson['Pages'] as $router) {
    $fileName = $router['name_file'];
    $fileContent = '<body><p class="text-center" style="margin-top: 3em;">Страницы еще не существует, вернитесь позже.</p></body>
'; // Шаблон содержимого в файле страницы

    if (!file_exists("$folder/$fileName")) {
        file_put_contents("$folder/$fileName", $fileContent);
        echo "Файл $fileName успешно создан.\n";
    } else {
        echo "Файл $fileName уже существует.\n";
    }

    $functionName = $router['name_func'];
    $controllerType = $router['controller'];
    $nameController=$controllerType."Controller";
    $functionExists = false;

        $validationUrl = $router['url'];
        $slashCount = substr_count($validationUrl, '/');
        
        $vars = "";
        for ($i = 1; $i <= $slashCount; $i++) {
            $vars .= "\$var" . $i . ",";
        }
        $vars = rtrim($vars, ",");

    // Проверка наличия функции в контроллере
    $functionExists = false;
    $existingFunctionPattern = "/public function $functionName\((.*?)\)/";
    preg_match($existingFunctionPattern, $controllerContent, $existingFunctionMatches);
    
    if (!empty($existingFunctionMatches)) {
        $existingFunctionParams = $existingFunctionMatches[1];
        if ($existingFunctionParams !== $vars) {
            // Удаление существующей функции из контроллера
            $controllerContent = preg_replace("/public function $functionName\((.*?)\)\s*{.*?}\n/s", '', $controllerContent);
            echo "Функция $functionName с другим количеством параметров была удалена из контроллера.\n";
        } else {
            $functionExists = true;
            echo "Функция $functionName уже существует в контроллере. Пропускаем добавление.\n";
        }
    }

    // Создание контроллера, если он не существует
    if (strpos($controllerContent, "class $nameController") === false) {
        $controllerContent .= "\n\nclass $nameController extends CA {\n    // Код контроллера $controllerType\n}";
        echo "Контроллер $controllerType успешно создан и добавлен в файл.\n";
    }

    // Добавление функции в контроллер
    if (!$functionExists) { 
        
        
        $functionContent = "    public function $functionName($vars) {\n       ".malware($nameController,$vars)."\n      include '$folder/$fileName';\n    }\n";
        $controllerContent = preg_replace("/class $nameController extends CA \{/", "class $nameController extends CA {\n$functionContent", $controllerContent, 1);
        echo "Функция $functionName успешно добавлена в контроллер $controller.\n";
    }
}

file_put_contents("routers/controllers.php", $controllerContent);

echo "Страницы созданы!\n";

function collection(){
    $pages = [];
    $routes = [];
    $pages = json_decode(file_get_contents('Pages.config.json'), true)['Pages'];

    $routes = include 'routers/collection.php';
    


    foreach ($pages as $page) {
        $url = $page['url'];
        $controller = $page['controller'];
        $function = $page['name_func'];

        $pattern = "#^{$url}$#";
        $route = "{$controller}Controller@{$function}";

        $routes[$pattern] = $route;
    }

    $fileContent = "<?php return [\n";
    foreach ($routes as $pattern => $route) {
        $fileContent .= "    '{$pattern}' => '{$route}',\n";
    }
    $fileContent .= "]; ?>\n";

    file_put_contents('routers/collection.php', $fileContent);

    echo "Пути страниц успешно добавлены в файл collection.php!\n";

}
collection();
?>