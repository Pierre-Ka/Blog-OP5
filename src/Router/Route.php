<?php
namespace BlogApp\Router;


class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private array $requirements;

    public function __construct($path, $callable, array $requirements = [])
    {
        // $path sans trim : '/posts/:id' avec trim : 'posts/:id'
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->requirements = $requirements;
    }

    public function matches($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);

//        foreach ($this->requirements as $key => $requirement) {
//            preg_match('/^:'.$key. '$/', $this->path, $toto);
//            var_dump($toto);die;
//        }
        // prams/toto/params2/titi
//        $params = explode('/', $url);
//        for ($i = 0; $i < count($params); $i += 2) {
//
//            echo $params[$i] . " has value: " . $params[$i + 1] . "<br />";
//
//        }
//
//
//        $params = explode('/', $this->path);
//        for ($i = 0; $i < count($params); $i += 2) {
//
//            echo $params[$i] . " has value: " . $params[$i + 1] . "<br />";
//
//        }
//
//die;
        // EXPLICATIONS : On remplace #:([\w]+)# par ([^/]+) dans $this->path

        // Notre parametre commence par : ( ex :id ) suivi de n'importe quel caractère alpha-numerique
        // repétés plusieurs fois = ([a-zA-Z0-9]+) ou en raccourci ([\w]+)
        // On le remplace  par tout sauf un / = [^/] repétés plusieurs fois = ([^/]+)

        // Donc par exemple, posts/:ab27 devient posts/:([^/]+)

        $regex = "#^$path$#i";
        // Ici on prepare notre path à être entrer dans la regex, i est insensible à la casse.
        // Pour reprendre notre exemple : #^posts/:([^/]+)$#

        // Si ça correspond pas : false
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        //var_dump($regex);
        //var_dump($url);
        //var_dump($matches);
        //die;
        return true;

    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
        // Description ¶call_user_func_array(callable $callback, array $args) appelle la fonction de rappel callback
        // fournie avec les paramètres args, rassemblés ous la forme d'un tableau indexé.
        /*
        ou
        $params = explode('->',$this->action);
        $controller = new $params[0][];
        $method = $params[1];
        return isset ($this->matches[1]) ? $controller->method($this->matches[1]) : $controller->$method();
        */
    }
}