<?php

namespace Novuso\Example\Controller;

use Twig_Environment;

/**
 * HomeController handles requests for the homepage
 *
 * @copyright Copyright (c) 2015, John Nickell. <http://johnnickell.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class HomeController
{
    /**
     * Twig environment
     *
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * Constructs HomeController
     *
     * @param Twig_Environment $twig The twig environment
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Handles a request for the homepage
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->twig->render('example/home/index.html.twig');
    }
}
