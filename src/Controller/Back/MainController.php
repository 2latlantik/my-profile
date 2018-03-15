<?php
namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller\Back
 * @Route("/back")
 */
class MainController extends Controller
{
    /**
     * @Route("", name="back_index")
     */
    public function indexPage()
    {
        return $this->render('public/index.html.twig');
    }
}
