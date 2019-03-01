<?php

Namespace App\Controller;

//Класс для отправки запроса клиенту
use Symfony\Component\HttpFoundation\Response;

//Класс, позволяющий настраивать маршрутизацию через аннотации
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MainController extends Controller
{

    /**
     * @Route(
     *     "/main/{locale}/{year}/{slug}.{format}",
     *     defaults={"format":"html"},
     *     requirements={
     *          "locale"="en|ru",
     *          "year"="\d+",
     *          "format"="html|rss"
     *     }
     * )
     */
    public function index($locale, $year, $slug, $format)
    {
        if ($locale == 'en') {
            return new Response(
               '<html><body><h1>Welcome to the main page</h1><br><h3>File <b>"'.$slug.'"</b> using format "'.$format.'" and was created in '.$year.' year</h3></body>'
            );
        }
        else {
            return new Response(
                '<html><body><h1>Добро пожаловать на главную страницу сайта</h1><br><h3>Файл "<b>'.$slug.'</b>" uспользует формат "'.$format.'" и был создан в '.$year.' году</h3></body>'
            );
        }
    }

    /*private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }*/


    /**
     * @Route("/main/test")
     */
    public function randomizer()
    {
        $number = mt_rand(0, 1000);

        //$url = $this->router->generate('main_index', array('locales' => 'ru', 'year' => '2000', 'slug' => 'posts'));
        //альтернатива twig {{ path('main_index', {'locales' => 'ru', 'year' => '2000', 'slug' => 'posts'})}}
        return new Response(
            '<html><body><b>Сгенерированное число: </b> '.$number.'<br> <a href="'.$url.'">на главную страницу</a></body>'
        );
    }

    /**
     * \d+ - это регулярное выражение, которое подходит под набор цифр любой длины
     *
     * @Route("/main/{page}", name="main_list", requirements={"page"="\d+"})
     */

    public function list($page = 1)
    {
        return $this->render('main/list.html.twig', array('page'=> $page));
    }

    /**
     * Так как путь маршрута /blog/{slug}, в show() определяется переменная $slug, совпадающая с этим значением. Например, если пользователь переходит на  /blog/yay-routing, тогда $slug будет равняться yay-routing
     *
     * @Route("/main/{slug}", name="main_show")
     */
    public function show($slug)
    {
        return new Response(
            '<html><body><b>Динамическая часть ссылки: '.$slug.'</b></body>'
        );
    }
}