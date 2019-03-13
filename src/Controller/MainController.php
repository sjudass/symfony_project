<?php

Namespace App\Controller;

//Класс для отправки запроса клиенту
use Symfony\Component\HttpFoundation\Response;

//Класс, позволяющий настраивать маршрутизацию через аннотации
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Psr\Log\LoggerInterface;

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
    public function locale($locale, $year, $slug, $format)
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

    /**
     * @Route("/main/index", name="app_main_index")
     */

    public function index(LoggerInterface $logger)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST'){
            $name = $_POST['name'];
            return $this->render('base.html.twig', ['name' => $name]);
        }

        $logger->info('We are logging!');

        return $this->render('base.html.twig');
    }

    /*private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }*/


    /**
     * @Route("/main/test", name="main_test")
     */
    public function randomizer()
    {
        $number = mt_rand(0, 1000);
        $url = $this->generateUrl('main_index', array('locales' => 'ru', 'year' => '2000', 'slug' => 'posts'));
        //$url = $this->router->generate('main_index', array('locales' => 'ru', 'year' => '2000', 'slug' => 'posts'));
        //альтернатива twig {{ path('main_index', {'locales' => 'ru', 'year' => '2000', 'slug' => 'posts'})}}
        return new Response(
            '<html><body><b>Сгенерированное число: </b> '.$number.'<br> <a href="'.$url.'">на главную страницу</a></body>'
        );
    }

    /**
     * @Route("/main/redirected", name="app_main_redirected")
     */

    public function redirected()
    {
        //Перенаправить по маршруту "homepage"
        //return $this->redirectToRoute('main_test');

        //redirecToRoute - это ярлык для:
        //вернуть новый RedirectResponse($this->generateUrl('homepage');

        //совершить постоянное перенаправление - 301
        //return $this->redirectToRoute('main_test', array(), 301);

        //перенаправить по маршруту с параметрами
        //return $this->redirectToRoute('main_index', array('locales' => 'en', 'year' => '2019', 'slug' => 'redirect', 'format' => 'rss'));

        //перенаправление внутренне
        return $this->redirect('https://vk.com/sjudass');
    }

    /**
     * \d+ - это регулярное выражение, которое подходит под набор цифр любой длины
     *
     * @Route("/main/{page}", name="main_list", requirements={"page"="\d+"})
     */

    public function list($page = 1)
    {

        return $this->render('main/index.html.twig', array('page'=> $page));
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